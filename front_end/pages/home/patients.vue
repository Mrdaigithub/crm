<template>
  <div class="patients">
    <h2>Patient</h2>
    <el-card class="box-card">
      <float-button @click.native="addPatient"/>
      <div class="form-group">
        <el-button @click="exportDialogVisible = true" type="primary">export</el-button>
      </div>
      <el-table :data="patientData" style="width: 100%" show-summary :summary-method="getPriceSum"
                @sort-change="sortChange" border>
        <el-table-column type="expand">
          <template scope="props">
            <el-form label-position="left" inline class="table-expands">
              <el-form-item label="disease: ">
                <span>{{ props.row.disease.name }}</span>
              </el-form-item>
              <el-form-item label="doctor: ">
                <span>{{ props.row.doctor.name }}</span>
              </el-form-item>
              <el-form-item label="channel: ">
                <span>{{ props.row.channel.name }}</span>
              </el-form-item>
              <el-form-item label="age: ">
                <span>{{ props.row.age }}</span>
              </el-form-item>
              <el-form-item label="first: ">
                <span>{{ props.row.first ? 'first' : 'many' }}</span>
              </el-form-item>
              <el-form-item label="mark: ">
                <span>{{ props.row.mark }}</span>
              </el-form-item>
            </el-form>
          </template>
        </el-table-column>
        <el-table-column prop="id" label="id" width="100" sortable="custom"></el-table-column>
        <el-table-column prop="name" label="name" width="150"></el-table-column>
        <el-table-column prop="sex" label="sex" width="100" sortable="custom"></el-table-column>
        <el-table-column prop="age" label="age" width="100" sortable="custom"></el-table-column>
        <el-table-column prop="tel" label="tel" width="150"></el-table-column>
        <el-table-column prop="created_at" label="created time" width="180" sortable="custom"></el-table-column>
        <el-table-column prop="advisory_date" label="advisory date" width="180" sortable="custom"></el-table-column>
        <el-table-column prop="arrive_date" label="arrive date" width="180" sortable="custom"></el-table-column>
        <el-table-column label="user" width="100">
          <template scope="scope">
            <p>{{ scope.row.user.username }}</p>
          </template>
        </el-table-column>
        <el-table-column prop="price" label="price" width="120" sortable="custom"></el-table-column>
        <el-table-column label="state" width="140">
          <template scope="scope">
            <el-select v-model="scope.row.state" :disabled="scope.row.state === 2"
                       @change="changeState(scope.row.id, scope.row.state, scope.$index)">
              <el-option :value="0" label="untreated"></el-option>
              <el-option :value="1" label="wait"></el-option>
              <el-option :value="2" label="confirm"></el-option>
              <el-option :value="3" label="cancel"></el-option>
            </el-select>
          </template>
        </el-table-column>
        <el-table-column label="tools" width="130">
          <template scope="scope">
            <el-button size="small" icon="edit" @click="editPatient(scope.$index, scope.row)"></el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removePatient(scope.$index, scope.row)"></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination layout="prev, pager, next" :total="patientTotal" :current-page="currentPage" @current-change="changePage" class="pagination"></el-pagination>
    </el-card>
    <el-dialog title="" :visible.sync="addDialogVisible" size="large" top="5%">
      <el-form :model="editForm.data" :rules="editForm.rules" ref="editForm" label-width="130px" label-position="left">
        <el-row>
          <el-col :span="10">
            <el-card style="min-height: 68vh">
              <div slot="header" class="clearfix">
                <h2>Base info</h2>
              </div>
              <el-form-item prop="name">
                <el-input v-model="editForm.data.name" placeholder="name" @blur="checkedRepeatName"></el-input>
              </el-form-item>
              <el-form-item prop="tel">
                <el-input v-model="editForm.data.tel" placeholder="tel"></el-input>
              </el-form-item>
              <el-form-item prop="price">
                <el-input v-model.number="editForm.data.price" placeholder="price"></el-input>
              </el-form-item>
              <el-form-item prop="advisoryDate" required>
                <el-date-picker v-model="editForm.data.advisoryDate"
                                type="datetime"
                                placeholder="advisory date"
                                align="right"
                                format="yy-MM-dd hh:mm:ss"></el-date-picker>
              </el-form-item>
              <el-form-item prop="advisoryId">
                <el-select v-model="editForm.data.advisoryId" placeholder="select advisory">
                  <el-option v-for="advisory of $store.state.advisories" :label="advisory.name" :value="advisory.id"
                             :key="advisory.id"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="channelId">
                <el-select v-model="editForm.data.channelId" placeholder="select channel">
                  <el-option v-for="channel of $store.state.channels" :label="channel.name" :value="channel.id"
                             :key="channel.id"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="doctorId">
                <el-select v-model="editForm.data.doctorId" placeholder="select doctor">
                  <el-option v-for="doctor of $store.state.doctors" :label="doctor.name" :value="doctor.id"
                             :key="doctor.id"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="diseaseId">
                <el-select v-model="editForm.data.diseaseId" placeholder="select disease">
                  <el-option-group v-for="disease of $store.state.diseases" :key="disease.id" :label="disease.name"
                                   v-if="disease.children.length">
                    <el-option v-for="d of disease.children" :key="d.id" :label="d.name" :value="d.id"></el-option>
                  </el-option-group>
                  <el-option v-for="disease of $store.state.diseases" :key="disease.id" :label="disease.name"
                             :value="disease.id" v-if="!disease.children.length"></el-option>
                </el-select>
              </el-form-item>
            </el-card>
          </el-col>
          <el-col :span="13" :offset="1">
            <el-card style="min-height: 68vh">
              <div slot="header" class="clearfix">
                <h2>Detail info</h2>
              </div>
              <el-form-item prop="age">
                <el-input v-model.number="editForm.data.age" type="age" auto-complete="off"
                          placeholder="age"></el-input>
              </el-form-item>
              <el-form-item prop="sex">
                <el-select v-model="editForm.data.sex" placeholder="sex">
                  <el-option label="man" value="0"></el-option>
                  <el-option label="woman" value="1"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="first">
                <el-select v-model="editForm.data.first" placeholder="first">
                  <el-option label="first" value="1"></el-option>
                  <el-option label="more" value="0"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="wechat">
                <el-input v-model="editForm.data.wechat" placeholder="wechat"></el-input>
              </el-form-item>
              <el-form-item prop="keyword">
                <el-input v-model="editForm.data.keyword" placeholder="keyword"></el-input>
              </el-form-item>
              <el-form-item prop="pageurl">
                <el-input v-model="editForm.data.pageurl" placeholder="www.pageurl.com">
                  <template slot="prepend">http://</template>
                </el-input>
              </el-form-item>
              <el-form-item prop="mark">
                <el-input type="textarea" :rows="4" v-model="editForm.data.mark" placeholder="mark"></el-input>
              </el-form-item>
            </el-card>
          </el-col>
        </el-row>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button style="width: 100%" type="primary" @click="savePatient('editForm')">S u b m i t</el-button>
      </span>
    </el-dialog>
    <el-dialog title="" :visible.sync="exportDialogVisible">
      <el-card>
        <el-form :model="exportForm.data">
          <el-row>
            <el-col :span="9">
              <el-form-item prop="name">
                <el-input v-model="exportForm.data.name" placeholder="name"></el-input>
              </el-form-item>
              <el-form-item prop="tel">
                <el-input v-model="exportForm.data.tel" placeholder="tel"></el-input>
              </el-form-item>
              <el-form-item prop="state">
                <el-select v-model="exportForm.data.state" placeholder="select state">
                  <el-option :value="0" label="untreated"></el-option>
                  <el-option :value="1" label="wait"></el-option>
                  <el-option :value="2" label="confirm"></el-option>
                  <el-option :value="3" label="cancel"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="dateType">
                <el-select v-model="exportForm.data.dateType" placeholder="select date type">
                  <el-option label="created_at" value="created_at"></el-option>
                  <el-option label="arrive_date" value="arrive_date"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="dateRange">
                <el-date-picker v-model="exportForm.data.dateRange" type="daterange"
                                :picker-options="exportForm.pickerOptions" placeholder="date range" format="yyyy-MM-dd">
                </el-date-picker>
              </el-form-item>
            </el-col>
            <el-col :span="11" :offset="3">
              <el-form-item prop="userId">
                <el-select v-model="exportForm.data.userId" placeholder="select user">
                  <el-option v-for="user of $store.state.users" :label="user.username" :value="user.id"
                             :key="user.id"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="channelId">
                <el-select v-model="exportForm.data.channelId" placeholder="select channel">
                  <el-option v-for="channel of $store.state.channels" :label="channel.name" :value="channel.id"
                             :key="channel.id"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="diseaseId">
                <el-select v-model="exportForm.data.diseaseId" placeholder="select disease">
                  <el-option-group v-for="disease of $store.state.diseases" :key="disease.id" :label="disease.name"
                                   v-if="disease.children.length">
                    <el-option v-for="d of disease.children" :key="d.id" :label="d.name" :value="d.id"></el-option>
                  </el-option-group>
                  <el-option v-for="disease of $store.state.diseases" :key="disease.id" :label="disease.name"
                             :value="disease.id" v-if="!disease.children.length"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="doctorId">
                <el-select v-model="exportForm.data.doctorId" placeholder="select doctor">
                  <el-option v-for="doctor of $store.state.doctors" :label="doctor.name" :value="doctor.id"
                             :key="doctor.id"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item prop="advisoryId">
                <el-select v-model="exportForm.data.advisoryId" placeholder="select advisory">
                  <el-option v-for="advisory of $store.state.advisories" :label="advisory.name" :value="advisory.id"
                             :key="advisory.id"></el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
        </el-form>
      </el-card>
      <span slot="footer" class="dialog-footer">
        <a :href="exportUrl" target="_blank">
          <el-button style="width: 100%" type="primary" @click="exportDialogVisible = false">Export</el-button>
        </a>
      </span>
    </el-dialog>
    <el-dialog :show-close="false" :visible.sync="repeatDialogVisible" size="mini" class="repeatDialog">
      <header>{{repeatDialogTitle}}</header>
      <div class="repeat-patient-list">
        <div class="repeat-patient-item" v-for="repeatPatient of repeatPatients">
          <p>name: {{repeatPatient.name}}</p>
          <p>tel: {{repeatPatient.tel}}</p>
          <p>sex: {{repeatPatient.sex}}</p>
          <p>arrive_date: {{repeatPatient['arrive_date']}}</p>
          <p>created_at: {{repeatPatient['created_at']}}</p>
          <hr>
        </div>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="repeatDialogVisible=false">ok</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
  import FloatButton from '~components/FloatButton.vue'
  import axios from '../../config/axios'
  import qs from 'qs'

  export default {
    name: 'patients',
    components: {
      FloatButton
    },
    data () {
      return {
        currentPage: 1,
        sortby: 'id',
        order: 'asc',
        patients: {},
        repeatPatients: [],
        stateClock: false,
        addDialogVisible: false,
        exportDialogVisible: false,
        repeatDialogVisible: false,
        operationState: 'new',
        editForm: {
          data: {
            name: '',
            tel: '',
            advisoryDate: '',
            advisoryId: '',
            channelId: '',
            doctorId: '',
            diseaseId: '',
            price: '',
            age: '',
            sex: '',
            first: '',
            wechat: '',
            keyword: '',
            pageurl: '',
            mark: ''
          },
          rules: {
            name: {required: true, message: 'please enter patient name', trigger: 'blur'},
            tel: [
              {required: true, message: 'please enter patient tel', trigger: 'blur'},
              {
                pattern: /^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/,
                message: 'tel error',
                trigger: 'change'
              }
            ],
            price: {pattern: /^(\d*)$/, message: 'must number', trigger: 'blur'},
            age: {pattern: /^\d*$/, message: 'must age', trigger: 'blur'},
            advisoryDate: {required: true, type: 'date', message: 'please select date', trigger: 'change'},
            pageurl: {
              pattern: /^((http|ftp|https):\/\/)?[\w\-_]+(\.[\w\-_]+)+([\w\-.,@?^=%&amp;:/~+#]*[\w\-@?^=%&amp;/~+#])?$/i,
              message: 'must url',
              trigger: 'blur'
            },
            advisoryId: {
              validator: (rule, value, callback) => {
                if (value) callback()
                else callback('please select advisory')
              },
              trigger: 'blur'
            },
            channelId: {
              validator: (rule, value, callback) => {
                if (value) callback()
                else callback('select a channel')
              },
              trigger: 'blur'
            },
            doctorId: {
              validator: (rule, value, callback) => {
                if (value) callback()
                else callback('select a doctor')
              },
              trigger: 'blur'
            },
            diseaseId: {
              validator: (rule, value, callback) => {
                if (value) callback()
                else callback('select a disease')
              },
              trigger: 'blur'
            }
          }
        },
        exportForm: {
          data: {
            name: '',
            tel: '',
            state: '',
            dateType: '',
            dateRange: [new Date((new Date()).getTime() - 3600 * 1000 * 24 * 90), new Date()],
            userId: '',
            advisoryId: '',
            channelId: '',
            doctorId: '',
            diseaseId: ''
          },
          pickerOptions: {
            disabledDate (time) {
              return time.getTime() > Date.now()
            },
            shortcuts: [{
              text: 'one week',
              onClick (picker) {
                const end = new Date()
                const start = new Date()
                start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
                picker.$emit('pick', [start, end])
              }
            }, {
              text: 'one month',
              onClick (picker) {
                const end = new Date()
                const start = new Date()
                start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
                picker.$emit('pick', [start, end])
              }
            }, {
              text: 'three month',
              onClick (picker) {
                const end = new Date()
                const start = new Date()
                start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
                picker.$emit('pick', [start, end])
              }
            }]
          }
        }
      }
    },
    computed: {
      patientData () {
        if (!this.patients.data) return []
        let patientData = this.patients.data.map(patient => {
          patient.sex = patient.sex ? 'woman' : 'man'
          return patient
        })
        return patientData
      },
      patientTotal () {
        if (!this.patients) return 0
        return this.patients.total
      },
      exportUrl () {
        let url = 'http://crm.mrdaisite.com/api/export?'
        if (this.exportForm.data.userId !== '') url += `user_id=${this.exportForm.data.userId}&`
        if (this.exportForm.data.channelId !== '') url += `channel_id=${this.exportForm.data.channelId}&`
        if (this.exportForm.data.advisoryId !== '') url += `advisory_id=${this.exportForm.data.advisoryId}&`
        if (this.exportForm.data.doctorId !== '') url += `doctor_id=${this.exportForm.data.doctorId}&`
        if (this.exportForm.data.diseaseId !== '') url += `disease_id=${this.exportForm.data.diseaseId}&`
        if (this.exportForm.data.state !== '') url += `state=${this.exportForm.data.state}&`
        if (this.exportForm.data.name !== '') url += `name=${this.exportForm.data.name}&`
        if (this.exportForm.data.tel !== '') url += `tel=${this.exportForm.data.tel}&`
        if (this.exportForm.data.dateType !== '') url += `date_type=${this.exportForm.data.dateType}&`
        url += `start_date=${this.exportForm.data.dateRange[0].toLocaleDateString().replace(/\//g, '-')}&end_date=${this.exportForm.data.dateRange[1].toLocaleDateString().replace(/\//g, '-')}`
        return url
      },
      repeatDialogTitle () {
        if (!this.repeatPatients) return `Tip! has 0 repeat patient`
        return `Tip! has ${this.repeatPatients.length} repeat patient`
      }
    },
    methods: {
      addPatient () {
        this.operationState = 'new'
        this.initPatientFormData()
      },
      editPatient (index, row) {
        this.operationState = 'edit'
        this.initPatientFormData(index, row)
      },
      removePatient (index, row) {
        axios.delete(`/patients/${row.id}`)
          .then(res => this.fetchPatients())
      },
      changeState (patientId, patientState, index) {
        if (this.stateClock) return
        if (patientState === 2) {
          let now = new Date()
          let year = now.getFullYear()
          let month = (now.getMonth() + 1).toString().length === 1 ? `0${(now.getMonth() + 1)}` : now.getMonth() + 1
          let day = now.getDay().toString().length === 1 ? `0${now.getDay()}` : now.getDay()
          let hours = now.getHours().toString().length === 1 ? `0${now.getHours()}` : now.getHours()
          let minutes = now.getMinutes().toString().length === 1 ? `0${now.getMinutes()}` : now.getMinutes()
          let seconds = now.getSeconds().toString().length === 1 ? `0${now.getSeconds()}` : now.getSeconds()
          this.patientData[index]['arrive_date'] = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`

          axios.patch(`/patients/${patientId}`, qs.stringify({
            state: patientState,
            arrive_date: this.patientData[index]['arrive_date']
          })).then(res => {
          })
          return
        }
        axios.patch(`/patients/${patientId}`, qs.stringify({
          state: patientState
        })).then(res => {
        })
      },
      changePage (currentPage) {
        this.currentPage = currentPage
        this.fetchPatients()
      },
      fetchPatients (callback = () => {}) {
        this.stateClock = true
        let self = this
        !(async function () {
          self.$store.state.loading = true
          self.patients = await axios.get(`/patients?page=${self.currentPage}&sortby=${self.sortby}&order=${self.order}`)
          setTimeout(() => {
            self.stateClock = false
            self.$store.state.loading = false
            callback()
          }, 0)
        }())
      },
      initPatientFormData (index = null, row = null) {
        if (this.operationState === 'new') {
          this.editForm.data.name = 'patient13'
          this.editForm.data.tel = ''
          this.editForm.data.advisoryDate = ''
          this.editForm.data.advisoryId = ''
          this.editForm.data.channelId = ''
          this.editForm.data.doctorId = ''
          this.editForm.data.diseaseId = ''
          this.editForm.data.price = ''
          this.editForm.data.age = ''
          this.editForm.data.sex = ''
          this.editForm.data.first = ''
          this.editForm.data.wechat = ''
          this.editForm.data.keyword = ''
          this.editForm.data.pageurl = ''
          this.editForm.data.mark = ''
        }
        if (this.operationState === 'edit') {
          this.editForm.data.id = row.id
          this.editForm.data.name = row.name
          this.editForm.data.tel = row.tel
          this.editForm.data.advisoryDate = new Date(row['advisory_date'])
          this.editForm.data.advisoryId = row.advisory.id
          this.editForm.data.channelId = row.channel.id
          this.editForm.data.diseaseId = row.disease.id
          this.editForm.data.doctorId = row.doctor.id
          this.editForm.data.price = row.price
          this.editForm.data.age = row.age
          this.editForm.data.sex = row.sex === 'man' ? '0' : '1'
          this.editForm.data.first = row.first
          this.editForm.data.wechat = row.wechat
          this.editForm.data.keyword = row.keyword
          this.editForm.data.pageurl = row.pageurl
          this.editForm.data.mark = row.mark
        }
        this.addDialogVisible = true
      },
      savePatient (formName) {
        let self = this
        let postPatientData = {
          id: this.editForm.data.id,
          name: this.editForm.data.name,
          tel: this.editForm.data.tel,
          state: 0,
          advisory_date: this.editForm.data.advisoryDate,
          advisory_id: this.editForm.data.advisoryId,
          channel_id: this.editForm.data.channelId,
          disease_id: this.editForm.data.diseaseId,
          doctor_id: this.editForm.data.doctorId,
          user_id: this.$store.state.oneself.id
        }
        postPatientData.price = this.editForm.data.price ? this.editForm.data.price : 0
        if (this.editForm.data.age) postPatientData.age = this.editForm.data.age
        if (this.editForm.data.sex) postPatientData.sex = this.editForm.data.sex
        if (this.editForm.data.first) postPatientData.first = this.editForm.data.first
        if (this.editForm.data.wechat) postPatientData.wechat = this.editForm.data.wechat
        if (this.editForm.data.keyword) postPatientData.keyword = this.editForm.data.keyword
        if (this.editForm.data.pageurl) postPatientData.pageurl = this.editForm.data.pageurl.match(/^https?:\/\//) ? this.editForm.data.pageurl : `http://${this.editForm.data.pageurl}`
        if (this.editForm.data.mark) postPatientData.mark = this.editForm.data.mark
        this.$refs[formName].validate((valid) => {
          if (valid) {
            if (this.operationState === 'new') {
              axios.post('/patients', qs.stringify(postPatientData))
                .then(res => {
                  self.currentPage = self.patients['last_page']
                  self.fetchPatients(() => {
                    self.currentPage = self.patients['last_page']
                    self.addDialogVisible = false
                  })
                })
            } else if (this.operationState === 'edit') {
              axios.patch(`/patients/${postPatientData.id}`, qs.stringify(postPatientData))
                .then(res => {
                  self.currentPage = self.patients['last_page']
                  self.fetchPatients(() => {
                    self.currentPage = self.patients['last_page']
                    self.addDialogVisible = false
                  })
                })
            }
          } else {
            return false
          }
        })
      },
      getPriceSum ({columns, data}) {
        const sums = []
        columns.forEach((column, index) => {
          if (index === 0) {
            sums[index] = 'Price'
            return
          } else if (column.label === 'price') {
            const values = data.map(item => Number(item[column.property]))
            const priceSum = values.reduce((prev, curr) => {
              return prev + curr
            }, 0)
            sums[index] = `$ ${priceSum}`
          } else {
            sums[index] = ''
          }
        })
        return sums
      },
      sortChange (args) {
        this.sortby = args.prop ? args.prop : 'id'
        if (args.order === 'ascending' || !args.order) this.order = 'asc'
        else this.order = 'desc'
        this.fetchPatients()
      },
      checkedRepeatName () {
        let self = this
        if (!this.editForm.data.name) return
        axios.get(`patients/${this.editForm.data.name}`)
          .then(res => {
            self.repeatPatients = res
            if (self.repeatPatients.length > 0) self.repeatDialogVisible = true
          })
      }
    },
    mounted () {
      this.currentPage = 1
      this.fetchPatients()
    }
  }
</script>

<style lang="scss">
  .repeatDialog {
    .el-dialog {
      .el-dialog__header, .el-dialog__body {
        background-color: #393d49;
        color: #fff;
      }
      .el-dialog__header {
        padding: 0;
      }
      .el-dialog__body {
        max-height: 60vh;
        overflow-y: scroll;
        header {
          font-size: 18px;
          line-height: 36px;
          margin-bottom: 10px;
        }
        .repeat-patient-list {
          .repeat-patient-item {
            p {
              line-height: 20px;
            }
            hr {
              display: block;
              margin: 10px 0 20px 0;
            }
          }
        }
      }
      .el-dialog__footer {
        background-color: #fff;
        text-align: center;
      }
    }
  }
  .table-expands > .el-form-item {
    display: block;
    margin-bottom: 0
  }
</style>
