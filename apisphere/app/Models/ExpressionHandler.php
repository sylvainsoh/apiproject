<?php

namespace App\Models;

class ExpressionHandler
{
    /**
     * Data
     *
     * @var array
     */
    private array $data;

    /**
     * Expression
     *
     * @var string
     */
    private string $expression;

    /**
     * Constructor
     *
     * @param array $data
     * @param string $expression
     */
    public function __construct(array $data, string $expression)
    {
        $this->data = $data;
        $this->expression = $expression;
    }

    /**
     * Get result of the executed expression
     *
     * @return string
     */
    public function getResult(): string
    {
        //Execute expression
        $this->applyExpressionFunctions()
                ->applyExpressionVariables()
                ->applyExpressionConcatenations()
                ->applyTernaryOperators()
                ->clean();

        //Return result
        return $this->expression;
    }

    /**
     * Replace input with functions by their values in the expression
     *
     * @return ExpressionHandler
     */
    private function applyExpressionFunctions(): ExpressionHandler
    {
        //Get inputs with functions
        $matches = [];
        preg_match_all('/(\$input\d+)(->)([^ ~?:]*)/', $this->expression, $matches);
         //Prepare replacements
        $replacesValues = [];

        foreach ($matches[1] as $key => $inputName) {
            //Get content from request param
            $content = $this->data[str_replace('$', '', $inputName)];
            //Build input
            $input = new \App\Models\Input($content);

            //Apply functions
            $functions = explode('->', $matches[3][$key]);

            foreach ($functions as $function) {
                //Apply function
                $functionParts = [];
                preg_match('/(.+)\((.*)\)/', $function, $functionParts);

                $functionName = $functionParts[1];
                $functionParams = $functionParts[2] ?? null;

                $input = empty($functionParams)
                        ? $input->{$functionName}()
                        : $input->{$functionName}($functionParams);

                $replacesValues[$matches[0][$key]] = ($input instanceof \App\Models\Input) ? $input->__toString() : $input;
            }
        }

        //Replace values in expression
        $this->expression = str_replace(array_keys($replacesValues), array_values($replacesValues), $this->expression);

        return $this;
    }

    /**
     * Replace inputs by their values in the expression
     *
     * @return ExpressionHandler
     */
    private function applyExpressionVariables(): ExpressionHandler
    {
        //Get inputs with functions
        $matches = [];
        preg_match_all('/(\$)(input\d+)/', $this->expression, $matches);

        //Prepare replacements
        $replacesValues = [];
        foreach ($matches[0] as $key => $match) {
            //Replaces values
            $replacesValues[$match] = $this->data[$matches[2][$key]];
        }

        //Replace values in expression
        $this->expression = str_replace(array_keys($replacesValues), array_values($replacesValues), $this->expression);

        return $this;
    }

    /**
     * Apply the concatenations in the expression
     *
     * @return ExpressionHandler
     */
    private function applyExpressionConcatenations(): ExpressionHandler
    {
        $result = '';

        //Concatenation parts
        $parts = explode('~', $this->expression);

        //Concatenate
        foreach ($parts as $part) {
            $result .= trim($part);
        }

        //Return
        $this->expression = $result;

        return $this;
    }

    /**
     * Apply the ternary operators
     *
     * @return ExpressionHandler
     */
    private function applyTernaryOperators(): ExpressionHandler
    {
        //Get ternary operators
        $matches = [];
        preg_match_all('/\((.+)(\?)(.+)(\:)(.+)\)/', $this->expression, $matches);

        //Prepare replacements
        $replacesValues = [];
        foreach ($matches[0] as $key => $search) {
            //Get ternary operator parts
            $condition = $matches[1][$key];
            $trueValue = trim($matches[3][$key]);
            $falseValue = trim($matches[5][$key]);

            //Get correct value
            $replacesValues[$search] = $this->evaluateCondition($condition) ? $trueValue : $falseValue;
        }

        //Replace values in expression
        $this->expression = str_replace(array_keys($replacesValues), array_values($replacesValues), $this->expression);

        return $this;
    }

    /**
     * Remove special characters from the expression
     *
     * @return ExpressionHandler
     */
    private function clean(): ExpressionHandler
    {
        //Remove special characters and create clean email
        $email = str_replace(['\'', '"'], '', $this->expression);
        $emailSanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

        //Lower characters
        $this->expression = str($emailSanitized)->lower();

        return $this;
    }

    /**
     * Evaluate a condition
     *
     * @param string $condition
     * @return bool
     * @throws \Exception
     */
    private function evaluateCondition(string $condition): bool
    {
        //Operators available
        $operators = [
            '<',
            '<=',
            '>',
            '>=',
            '!=',
            '!==',
            '==',
            '==='
        ];

        //Init result
        $result = null;

        foreach ($operators as $operator) {
            if(str_contains($condition, $operator)) {
                //Handle operator
                $parts = explode($operator, $condition);
                $part1 = trim($parts[0]);
                $part2 = trim($parts[1]);

                switch ($operator) {
                    case '<':
                        $result =  $part1 < $part2;
                        break;
                    case '<=':
                        $result =  $part1 <= $part2;
                        break;
                    case '>':
                        $result =  $part1 > $part2;
                        break;
                    case '>=':
                        $result =  $part1 >= $part2;
                        break;
                    case '!=':
                        $result =  $part1 != $part2;
                        break;
                    case '!==':
                        $result =  $part1 !== $part2;
                        break;
                    case '==':
                        $result =  $part1 == $part2;
                        break;
                    case '===':
                        $result =  $part1 === $part2;
                        break;
                    default:
                        $result = null;
                        break;
                }
            }
        }

        //No result
        if($result === null) {
            throw new \Exception("Operator not handled in condition" . $condition);
        }

        //Return
        return $result;
    }
}
