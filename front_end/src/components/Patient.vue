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
          <Select v-model="patientData.advisoryWay" placeholder="请选择咨询方式">
            <Option v-for="item in patientData.advisoryWayData" :value="item.value" :key="item">{{ item.value }}
            </Option>
          </Select>
        </Form-item>
        <Form-item label="渠道来源">
          <Select v-model="patientData.media" placeholder="请选择渠道来源">
            <Option v-for="item in patientData.mediaData" :value="item.value" :key="item">{{ item.value }}</Option>
          </Select>
        </Form-item>
        <Form-item label="预约病种">
          <Select v-model="patientData.disease" placeholder="请选择预约病种">
            <Option v-for="item in patientData.diseaseData" :value="item.value" :key="item">{{ item.value }}</Option>
          </Select>
        </Form-item>
        <Form-item label="预约医生">
          <Select v-model="patientData.doctor" placeholder="请选择预约医生">
            <Option v-for="item in patientData.doctorData" :value="item.value" :key="item">{{ item.value }}</Option>
          </Select>
        </Form-item>
        <Form-item label="客户预约备注" prop="marks">
          <Input v-model="patientData.marks" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="请输入..."></Input>
        </Form-item>
      </Form>
      <div slot="footer"></div>
    </Modal>
    <Table :columns="patientCols" :data="patientData"></Table>
    <Page :total="page.total" show-elevator :page-size="page.perPage" @on-change="changePage"></Page>
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
          advisoryWayData: [
            {
              value: '商务通'
            },
            {
              value: '电话'
            }
          ],
          media: '',
          mediaData: [
            {
              value: '百度'
            },
            {
              value: '搜狗'
            },
            {
              value: '360'
            }
          ],
          disease: '',
          diseaseData: [
            {
              value: '近视眼'
            },
            {
              value: '支气管'
            },
            {
              value: '智障'
            },
            {
              value: '中二'
            }
          ],
          doctor: '',
          doctorData: [
            {
              value: 'doctor1'
            },
            {
              value: 'doctor2'
            },
            {
              value: 'doctor3'
            },
            {
              value: 'doctor4'
            }
          ],
          marks: '',
          city: '',
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
          media: [
            {required: true, message: '请选择城市', trigger: 'change'}
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
        },
        page: {
          total: 0,
          pageData:[],
          perPage: 30,
          sortBy:'id',
          order:'asc'
        },
        patientCols:[
          {
            title: 'id',
            key: 'id'
          },
          {
            title: '姓名',
            key: 'name'
          },
          {
            title: '性别',
            key: 'sex'
          },
          {
            title: '电话',
            key: 'tel'
          },
          {
            title: '年龄',
            key: 'age'
          },
          {
            title: '微信',
            key: 'wechat'
          },
          {
            title: 'qq',
            key: 'qq'
          },
          {
            title: '添加时间',
            key: 'addTime'
          },
          {
            title: '预约时间',
            key: 'orderTime'
          },
          {
            title: '到诊时间',
            key: 'reachTime'
          },
          {
            title: '病症id',
            key: 'diseaseId'
          },
          {
            title: '经办人',
            key: 'authorId'
          },
          {
            title: '病人状态',
            key: 'state'
          },
          {
            title: '医生id',
            key: 'doctorId'
          },
          {
            title: '来源',
            key: 'advisoryWay'
          }
        ],
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
      },
      changePage(currentPage){
        let url = `http://localhost/crm/back_end/api/v1/patient/?page=${currentPage}&per_page=${this.page.perPage}&sort_by=${this.page.sortBy}&order=${this.page.order}`
        let getPageData = async ()=>{
          let res = (await axios.get(url)).data
        }
        getPageData()
      }
    },
    mounted(){
      let getPatients = async () => {
        let res = (await axios.get('http://localhost/crm/back_end/api/v1/patient/?count=1')).data
        this.page.total = parseInt(res.count)
      }
      getPatients()
    }
  }
</script>
<style>
</style>
