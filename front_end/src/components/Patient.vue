<template>
  <div>
    <h1>patient</h1>
    <Button type="primary" @click="patientModal=true">add</Button>
    <Modal title="新增客户信息 - 登记人[boss]" v-model="patientModal" width="900">
      <Form ref="patientData" :model="patientData" :rules="patientRule" :label-width="70" label-position="left">
        <Form-item label="客户姓名" prop="name">
          <Input v-model="patientData.name" placeholder="客户姓名必须填写"></Input>
        </Form-item>
        <Form-item label="客户电话" prop="tel">
          <Input v-model="patientData.tel" placeholder="客户电话不能为空"></Input>
        </Form-item>
        <Form-item label="选择日期">
          <Row>
            <Col span="11">
            <Form-item prop="date">
              <Date-picker type="date" placeholder="选择日期" v-model="patientData.date"></Date-picker>
            </Form-item>
            </Col>
            <Col span="2" style="text-align: center">
            -</Col>
            <Col span="11">
            <Form-item prop="time">
              <Time-picker type="time" placeholder="选择时间" v-model="patientData.time"></Time-picker>
            </Form-item>
            </Col>
          </Row>
        </Form-item>
        <Form-item label="咨询方式">
          <Select v-model="patientData.advisoryWay" placeholder="请选择">
            <Option v-for="item in patientData.advisoryWayData" :value="item.value" :key="item">{{ item.value }}</Option>
          </Select>
        </Form-item>
      </Form>
      <div slot="footer"></div>
    </Modal>
  </div>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    data () {
      return {
        self: this,
        patientModal: false,
        patientData: {
          name: '',
          tel: '',
          date: '',
          time: '',
          advisoryWay: '',
          advisoryWayData:[
            {
              value: '商务通'
            },
            {
              value: '电话'
            }
          ],
          city: '',
          gender: '',
          interest: [],
          desc: ''
        },
        patientRule: {
          name: [
            {required: true, message: '姓名不能为空', trigger: 'blur'}
          ],
          tel: [
            {required: true, message: '电话不能为空', trigger: 'blur'}
          ],
          date: [
            {required: true, type: 'date', message: '请选择日期', trigger: 'change'}
          ],
          time: [
            {required: true, type: 'date', message: '请选择时间', trigger: 'change'}
          ],
          city: [
            {required: true, message: '请选择城市', trigger: 'change'}
          ],
          gender: [
            {required: true, message: '请选择性别', trigger: 'change'}
          ],
          interest: [
            {required: true, type: 'array', min: 1, message: '至少选择一个爱好', trigger: 'change'},
            {type: 'array', max: 2, message: '最多选择两个爱好', trigger: 'change'}
          ],
          desc: [
            {required: true, message: '请输入个人介绍', trigger: 'blur'},
            {type: 'string', min: 20, message: '介绍不能少于20字', trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      addPatient(){
        let test = async () => {
          let patient = await axios.post('http://localhost/crm/back_end/api/v1/patient/', qs.stringify({
            token: localStorage.token,
            name: 'patient1',
            sex: 0,
            age: 20,
            tel: 13566666666,
            wechat: 'patient1-13566666666',
            qq: '666666',
            addTime: (new Date().getTime()).toString().split('').slice(0, -3).join(''),
            disease_id: 0,
            state: 0,
            media_from_id: 0,
            doctor_id: 0,
            advisory_way: 'swt',
            advisory_content: 'make a big news',
            area: '温州',
            remarks: '苟...'
          }))
        }
        test()
      }
    }
  }
</script>
<style>
</style>
