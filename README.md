## Backend Software Developer Technical Assessment – v23-02
 

## Task 1 : Docker
For the first task the _docker-compose.yaml_ is in the root folder of project, <br/>
And the others docker files are in the corresponding folders.


## Task 2 : Problem solving
For the second task the _docker-compose.yaml_ is in the **apishpere**, <br/>
To run the Laravel project you have to type :

``` bash
cd apisphere

./vendor/bin/sail up
```

There is an error in the example of expression pattern given in the document, <br>
The expression was given in Java
``` java
input1.eachWordFirstChars(1) ~ '.' ~ (input2.wordsCount() > 1 ? input2.lastWords(- 1).eachWordFirstChars(1) ~ input2.lastWords(1) : input2 ) ~ '@' ~ input3 ~ '.' ~ input4 ~ '.' ~ input5
``` 
The corresponding version in PHP is :
``` php
$input1->eachWordFirstChars(1) ~ '.' ~ ($input2->wordsCount() > 1 ? $input2->lastWords('-1')->eachWordFirstChars(1) ~ $input2->lastWords(1) : $input2) ~ '@' ~ $input3 ~ '.' ~ $input4 ~ '.' ~ $input5;
``` 
Question answer : The use of **eval()** function is not recommended due to performance and security issues

## Task 3 : Swagger
The implementation of _swagger_ is done and accessible here : 


http://localhost/api/documentation#/default/get_api_v1_0_emails_generator


<br/>
<p align="left">
<a href="https://www.linkedin.com/in/sylvainsoh/" target="_blank">
<img src="https://play-lh.googleusercontent.com/kMofEFLjobZy_bCuaiDogzBcUT-dz3BBbOrIEjJ-hqOabjK8ieuevGe6wlTD15QzOqw=w240-h480-rw" width="50" alt="Laravel Logo"></a><br>
 Sylvain SOH 
</p>
