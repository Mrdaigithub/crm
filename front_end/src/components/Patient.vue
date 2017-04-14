<template>
  <div>
    <h1>patient</h1>
    <Button type="primary" @click="patientModal = true">addPatient</Button>
    <Modal
      v-model="patientModal"
      title="新增客户信息 - 登记人[xx]" width="800">
      <Form
        :model="patientForm"
        label-position="left"
        ref="formValidate"
        :label-width="70">
        <Row>
          <Col span="8">
          <Form-item label="客户姓名">
            <Input v-model="patientForm.name" placeholder="客户姓名 *(必填)"></Input>
          </Form-item>
          <Form-item label="客户电话">
            <Input v-model="patientForm.tel" placeholder="客户电话 *(必填)"></Input>
          </Form-item>
          <!--<Form-item label="客户电话 *(必填)">-->
            <!--<Input v-model="formTop.input1" placeholder="客户电话不能为空"></Input>-->
          <!--</Form-item>-->
          <!--<Form-item label="预约时间">-->
            <!--<Date-picker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="选择日期和时间（不含秒）" style="width: 200px"></Date-picker>-->
          <!--</Form-item>-->
          <!--<Form-item label="咨询方式">-->
            <!--<Select v-model="model1" style="width:200px">-->
              <!--<Option v-for="item in cityList" :value="item.value" :key="item">{{ item.label }}</Option>-->
            <!--</Select>-->
          <!--</Form-item>-->
          <!--<Form-item label="预约病种 *(必选)">-->
            <!--<Select v-model="model7">-->
              <!--<Option-group label="热门城市">-->
                <!--<Option v-for="item in cityList1" :value="item.value" :key="item">{{ item.label }}</Option>-->
              <!--</Option-group>-->
              <!--<Option-group label="其它城市">-->
                <!--<Option v-for="item in cityList2" :value="item.value" :key="item">{{ item.label }}</Option>-->
              <!--</Option-group>-->
            <!--</Select>-->
          <!--</Form-item>-->
          <!--<Form-item label="预约医生">-->
            <!--<Select v-model="model1">-->
              <!--<Option v-for="item in cityList" :value="item.value" :key="item">{{ item.label }}</Option>-->
            <!--</Select>-->
          <!--</Form-item>-->
          <!--<Form-item label="客户预约备注">-->
            <!--<Input v-model="value8" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="请输入..."></Input>-->
          <!--</Form-item>-->
          </Col>
          <!--<Col span="16">-->
          <!--<h2>详细信息</h2>-->
          <!--<Row>-->
            <!--<Col span="12">-->
            <!--<Card>-->
              <!--<p slot="title"><Icon type="person-stalker"/>客户详细情况</p>-->
              <!--<Form-item label="年纪">-->
                <!--<Input-number :max="10" :min="1" v-model="value1"></Input-number>-->
              <!--</Form-item>-->
              <!--<Form-item label="年纪">-->
                <!--<Radio-group v-model="button4" type="button" size="large">-->
                  <!--<Radio label="男"></Radio>-->
                  <!--<Radio label="女"></Radio>-->
                <!--</Radio-group>-->
              <!--</Form-item>-->
              <!--<Form-item label="初诊">-->
                <!--<Radio-group v-model="button4" type="button" size="large">-->
                  <!--<Radio label="初诊"></Radio>-->
                  <!--<Radio label="复诊"></Radio>-->
                <!--</Radio-group>-->
              <!--</Form-item>-->
              <!--<Input type="text" v-model="formInline.user" placeholder="Username">-->
              <!--<Icon type="ios-person-outline" slot="prepend"></Icon>-->
              <!--</Input>-->
              <!--<Form-item label="客户微信">-->
                <!--<Input v-model="formTop.input1" placeholder="选填项,客户微信"></Input>-->
              <!--</Form-item>-->
              <!--<Form-item label="客户地址">-->
                <!--<Select v-model="model7" style="width:200px">-->
                  <!--<Option-group label="热门城市">-->
                    <!--<Option v-for="item in cityList1" :value="item.value" :key="item">{{ item.label }}</Option>-->
                  <!--</Option-group>-->
                  <!--<Option-group label="其它城市">-->
                    <!--<Option v-for="item in cityList2" :value="item.value" :key="item">{{ item.label }}</Option>-->
                  <!--</Option-group>-->
                <!--</Select>-->
              <!--</Form-item>-->
            <!--</Card>-->
            <!--</Col>-->
            <!--<Col span="12">-->
            <!--<Card>-->
              <!--<p slot="title">标准卡片</p>-->
              <!--<p>卡片内容</p>-->
              <!--<p>卡片内容</p>-->
              <!--<p>卡片内容</p>-->
            <!--</Card>-->
            <!--</Col>-->
          <!--</Row>-->
          <!--</Col>-->
        </Row>
      </Form>
      <p slot="footer">
        <Button type="success" @click="patientModal = true">submit</Button>
      </p>
    </Modal>
    <!--<Table border :context="self" :columns="columns7" :data="data6"></Table>-->
  </div>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    data () {
      return {
        self: this,
        patientModal:false,
        patientForm: {
          name: '',
          tel: '',
          input3: ''
        }
      }
    },
    methods: {
      addPatient(){
        let test = async ()=>{
          let patient = await axios.post('http://localhost/crm/back_end/api/v1/patient/',qs.stringify({
            token:localStorage.token,
            name:'patient1',
            sex:0,
            age:20,
            tel:13566666666,
            wechat:'patient1-13566666666',
            qq:'666666',
            addTime:(new Date().getTime()).toString().split('').slice(0,-3).join(''),
            disease_id:0,
            state:0,
            media_from_id:0,
            doctor_id:0,
            advisory_way:'swt',
            advisory_content:'make a big news',
            area:'温州',
            remarks:'苟...'
          }))
        }
        test()
      }
    }
  }
</script>
<style>
  .ivu-modal{
    height:80vh;
  }
</style>
