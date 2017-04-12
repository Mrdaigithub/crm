## Token接口


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
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|token|string|用户认证密钥|

 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|number|缺少token参数|





## Menu接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/menu/`

---

### 请求方式：
- GET 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |string |用户密钥   |


 ### 返回示例

``` 
  [
    {
      "title": "仪表盘",
      "name": "1",
      "url": "dashboard",
      "child": []
    },
    {
      "title": "客户池",
      "name": "2",
      "url": "patients",
      "child": [
        {
          "id": "3",
          "title": "登记用户",
          "name": "2-1",
          "url": "regsiter"
        }
      ]
    }
  ]
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|menu_data|array|用户对应的菜单数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|number|缺少token参数|
|40014|number|无效的token|
|42001|number|token超时|






## Patient接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/patient/`

---

### 请求方式：
- GET 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |string |用户密钥   |


 ### 返回示例

``` 
  [
    {
      "title": "仪表盘",
      "name": "1",
      "url": "dashboard",
      "child": []
    },
    {
      "title": "客户池",
      "name": "2",
      "url": "patients",
      "child": [
        {
          "id": "3",
          "title": "登记用户",
          "name": "2-1",
          "url": "regsiter"
        }
      ]
    }
  ]
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|menu_data|array|用户对应的菜单数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|number|缺少token参数|
|40014|number|无效的token|
|42001|number|token超时|


---

### 请求方式：
- POST

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |string |用户密钥   |
|name |是  |string |名字   |
|sex |否  |number（0/1） |性别   |
|age |否  |number |年纪   |
|tel |否  |string |电话   |
|wechat |否  |string |微信   |
|qq |否  |string |qq   |
|add_time |是  |timestamp |登记时间   |
|order_time |否  |timestamp |预约时间   |
|reach_time |否  |timestamp |到诊时间   |
|disease_id |否  |int |病种id   |
|state |是  |int |病患状态   |
|media_from_id |否  |int |来源id   |
|doctor_id |否  |int |预约专家id   |
|advisory_way |否  |string |咨询方式   |
|advisory_content |否  |string |咨询内容   |
|area |否  |string |地区   |
|remarks |否  |string |备注   |


 ### 返回示例

```
  {
    "newPatient": {
        "id": "1007",
        "name": "patient1",
        "sex": "0",
        "tel": "13566666666",
        "age": "20",
        "wechat": "patient1-13566666666",
        "qq": "666666",
        "addTime": "1491983355",
        "orderTime": null,
        "reachTime": null,
        "diseaseId": null,
        "authorId": "1",
        "state": "0",
        "mediaFromId": null,
        "doctorId": null,
        "advisoryWay": null,
        "advisoryContent": null,
        "area": "温州",
        "remarks": "苟..."
    }
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|newPatient|object|新建的病患数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|number|缺少token参数|
|40014|number|无效的token|
|42001|number|token超时|
