## token接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/token/`

---

### 请求方式：
- POST 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |


 ### 返回示例

``` 
  {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJyb290Iiwic3ViIjoiand0IiwiZXhwIjoxNDkxODgyODk5fQ.Y2IyNjQzOGY1OTBmMjc4N2MxNzFlNTkyODc2ZGRlYTQ2YzIyNjQwODkzODJjYTgwMTE3NjRmZmYxMDdmOWZlYg"
    }
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|token|string|用户认证密钥|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|40036|number|用戶名或密碼缺失|
|40035|number|用戶名或密碼不合法|
|46004|number|用户名错误或无此用户|
|46005|number|密码错误|
---



### 请求方式：
- PATCH 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |string |过期的token   |


 ### 返回示例

``` 
  {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJyb290Iiwic3ViIjoiand0IiwiZXhwIjoxNDkxODgyODk5fQ.Y2IyNjQzOGY1OTBmMjc4N2MxNzFlNTkyODc2ZGRlYTQ2YzIyNjQwODkzODJjYTgwMTE3NjRmZmYxMDdmOWZlYg"
    }
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|token|string|用户认证密钥|

 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|40036|number|用戶名或密碼缺失|
|40035|number|用戶名或密碼不合法|
|46004|number|用户名错误或无此用户|
|46005|number|密码错误|

