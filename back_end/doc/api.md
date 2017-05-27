## Token接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/token/`

---

### 请求方式：
- POST 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |String |用户名   |
|password |是  |String | 密码    |


 ### 返回示例

``` 
  {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJyb290Iiwic3ViIjoiand0IiwiZXhwIjoxNDkxODgyODk5fQ.Y2IyNjQzOGY1OTBmMjc4N2MxNzFlNTkyODc2ZGRlYTQ2YzIyNjQwODkzODJjYTgwMTE3NjRmZmYxMDdmOWZlYg"
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|token|String|用户认证密钥|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|40036|Number|用戶名或密碼缺失|
|40035|Number|用戶名或密碼不合法|
|46004|Number|用户名错误或无此用户|
|46005|Number|密码错误|
---



### 请求方式：
- PATCH 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |String |过期的token   |


 ### 返回示例

``` 
  {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJyb290Iiwic3ViIjoiand0IiwiZXhwIjoxNDkxODgyODk5fQ.Y2IyNjQzOGY1OTBmMjc4N2MxNzFlNTkyODc2ZGRlYTQ2YzIyNjQwODkzODJjYTgwMTE3NjRmZmYxMDdmOWZlYg"
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|token|String|用户认证密钥|

 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|Number|缺少token参数|





## Menu接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/menu/`

---

### 请求方式：
- GET 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |String |用户密钥   |


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
|menu_data|Array|用户对应的菜单数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|Number|缺少token参数|
|40014|Number|无效的token|
|42001|Number|token超时|






## Patient接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/patient/`

---

### 请求方式：
- GET 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |String |用户密钥   |


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
|menu_data|Array|用户对应的菜单数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|Number|缺少token参数|
|40014|Number|无效的token|
|42001|Number|token超时|


---

### 请求方式：
- POST

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |String |用户密钥   |
|name |是  |String |名字   |
|sex |否  |Number（0/1） |性别   |
|age |否  |Number |年纪   |
|tel |否  |String |电话   |
|wechat |否  |String |微信   |
|qq |否  |String |qq   |
|add_time |是  |timestamp |登记时间   |
|order_time |否  |timestamp |预约时间   |
|reach_time |否  |timestamp |到诊时间   |
|disease_id |否  |int |病种id   |
|state |是  |int |病患状态   |
|media_from_id |否  |int |来源id   |
|doctor_id |否  |int |预约专家id   |
|advisory_way |否  |String |咨询方式   |
|advisory_content |否  |String |咨询内容   |
|area |否  |String |地区   |
|remarks |否  |String |备注   |


 ### 返回示例

```
  {
    "new_patient": {
        "id": "1007",
        "name": "patient1",
        "sex": "0",
        "tel": "13566666666",
        "age": "20",
        "wechat": "patient1-13566666666",
        "qq": "666666",
        "add_time": "1491983355",
        "order_time": null,
        "reach_time": null,
        "disease_id": null,
        "author_id": "1",
        "state": "0",
        "media_from_id": null,
        "doctor_id": null,
        "advisory_way": null,
        "advisory_content": null,
        "area": "温州",
        "remarks": "苟..."
    }
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|new_patient|object|新建的病患数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|Number|缺少token参数|
|40014|Number|无效的token|
|42001|Number|token超时|




## Permission接口


### 请求URL： 
- ` http://xx.com/back_end/api/v1/permission/`

---

### 请求方式：
- GET 

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |String |用户密钥   |
|role_name |是  |String |权限组名称   |


 ### 返回示例

``` 
  [
    {
      "title": "系统后台",
      "expand": true,
      "checked": true
    },
    {
      "title": "允许修改客户预约医生",
      "expand": true,
      "checked": true
    },
    {
      "title": "参数设置",
      "expand": true,
      "checked": false
    }
    ...
  ]
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|permission_data|Array|权限组对应的权限数据|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|Number|缺少token参数|
|40014|Number|无效的token|
|42001|Number|token超时|
|48001|Number|此用户无权访问|
|44001|Number|缺少权限组参数|
|43003|Number|请求方法错误|


---

### 请求方式：
- PUT

### 参数： 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|token |是  |String |用户密钥   |
|role_name |是  |String |权限组名称   |
|role_permission |是  |String |将要更新的权限值   |



 ### 返回示例

``` 
  {
    "role_permission": "11111111111111111111111111111000000000000000000000000000000000000"
  }
```

 ### 返回参数说明 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|role_permission|String|更新之后的权限值|


 ### 错误状态码 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|41001|Number|缺少token参数|
|40014|Number|无效的token|
|42001|Number|token超时|
|48001|Number|此用户无权访问|
|44001|Number|缺少权限组参数|
|44001|Number|缺少将要更新的权限值参数|
|43003|Number|请求方法错误|