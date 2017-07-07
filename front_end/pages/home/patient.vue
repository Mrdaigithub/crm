<template>
  <div class="patient" v-loading.body="loading">
    <el-card class="box-card">
      <h2>Patient</h2>
      <el-button type="success" icon="plus" class="add-doctor" @click="addPatient"></el-button>
      <el-table :data="patientData" style="width: 100%" height="500" border>
        <el-table-column prop="id" label="id" width="60" fixed></el-table-column>
        <el-table-column prop="name" label="name" width="120"></el-table-column>
        <el-table-column prop="sex" label="sex" width="100"></el-table-column>
        <el-table-column prop="age" label="age" width="80"></el-table-column>
        <el-table-column prop="tel" label="tel" width="140"></el-table-column>
        <el-table-column prop="created_at" label="created time" width="180"></el-table-column>
        <el-table-column prop="advisory_date" label="advisory date" width="180"></el-table-column>
        <el-table-column prop="arrive_date" label="arrive date" width="180"></el-table-column>
        <el-table-column label="disease" width="140">
          <template scope="scope">
            <p>{{ scope.row.disease.name }}</p>
          </template>
        </el-table-column>
        <el-table-column label="doctor" width="100">
          <template scope="scope">
            <p>{{ scope.row.doctor.name }}</p>
          </template>
        </el-table-column>
        <el-table-column label="user" width="100">
          <template scope="scope">
            <p>{{ scope.row.user.username }}</p>
          </template>
        </el-table-column>
        <el-table-column label="channel" width="100">
          <template scope="scope">
            <p>{{ scope.row.channel.name }}</p>
          </template>
        </el-table-column>
        <el-table-column prop="price" label="price" width="120"></el-table-column>
        <el-table-column label="channel" width="140">
          <template scope="scope">
            <el-select v-model="scope.row.state" @change="changeState(scope.row.id, scope.row.state)">
              <el-option :value="0" label="untreated"></el-option>
              <el-option :value="1" label="wait"></el-option>
              <el-option :value="2" label="confirm"></el-option>
              <el-option :value="3" label="cancel"></el-option>
            </el-select>
          </template>
        </el-table-column>
        <el-table-column label="tools" width="200">
          <template scope="scope">
            <el-button size="small" icon="edit" @click="editPatient(scope.$index, scope.row)"></el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removePatient(scope.$index, scope.row)"></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination layout="prev, pager, next" :total="patientTotal" :current-page="currentPage"
                     @current-change="changePage"></el-pagination>
    </el-card>
    <el-dialog title="" :visible.sync="dialogVisible" size="large" top="5%">
      <el-form :model="editForm.data" :rules="editForm.rules" ref="editForm" label-width="130px" label-position="left">
        <el-row>
          <el-col :span="10">
            <el-card style="min-height: 68vh">
              <div slot="header" class="clearfix"><h2>Base info</h2></div>
              <el-form-item label="name" prop="name">
                <el-input v-model="editForm.data.name"></el-input>
              </el-form-item>
              <el-form-item label="tel" prop="tel">
                <el-input v-model="editForm.data.tel"></el-input>
              </el-form-item>
              <el-form-item label="advisory date" required>
                <el-form-item prop="date">
                  <el-date-picker
                    v-model="editForm.data.date"
                    type="datetime"
                    placeholder="选择日期时间"
                    align="right"
                    format="yy-MM-dd hh:mm:ss">
                  </el-date-picker>
                </el-form-item>
              </el-form-item>
              <!--<el-form-item label="advisory" prop="advisory">-->
                <!--<el-select v-model="editForm.data.advisory" placeholder="select advisory">-->
                  <!--<el-option v-for="advisory of advisories" :label="advisory.name" :value="advisory.id"-->
                             <!--:key="advisory.id"></el-option>-->
                <!--</el-select>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="channel" prop="channel">-->
                <!--<el-select v-model="editForm.data.channel" placeholder="select channel">-->
                  <!--<el-option v-for="channel of channels" :label="channel.name" :value="channel.id"-->
                             <!--:key="channel.id"></el-option>-->
                <!--</el-select>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="doctor" prop="doctor">-->
                <!--<el-select v-model="editForm.data.doctor" placeholder="select doctor">-->
                  <!--<el-option v-for="doctor of doctors" :label="doctor.name" :value="doctor.id"-->
                             <!--:key="doctor.id"></el-option>-->
                <!--</el-select>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="disease" prop="disease">-->
                <!--<el-select v-model="editForm.data.disease" placeholder="select disease">-->
                  <!--<el-option-group v-for="disease of diseases" :key="disease.id" :label="disease.name"-->
                                   <!--v-if="disease.children.length">-->
                    <!--<el-option v-for="d of disease.children" :key="d.id" :label="d.name" :value="d.id"></el-option>-->
                  <!--</el-option-group>-->
                  <!--<el-option v-for="disease of diseases" :key="disease.id" :label="disease.name" :value="disease.id"-->
                             <!--v-if="!disease.children.length"></el-option>-->
                <!--</el-select>-->
              <!--</el-form-item>-->
            </el-card>
          </el-col>
          <!--<el-col :span="13" :offset="1">-->
            <!--<el-card style="min-height: 68vh">-->
              <!--<div slot="header" class="clearfix"><h2>Detail info</h2></div>-->
              <!--<el-form-item label="age" prop="age">-->
                <!--<el-input v-model.number="editForm.data.age" type="age" auto-complete="off"></el-input>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="sex" prop="sex">-->
                <!--<el-select v-model="editForm.data.sex" placeholder="man or woman?">-->
                  <!--<el-option label="man" value="0"></el-option>-->
                  <!--<el-option label="woman" value="1"></el-option>-->
                <!--</el-select>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="wechat" prop="wechat">-->
                <!--<el-input v-model="editForm.data.wechat"></el-input>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="keyword" prop="keyword">-->
                <!--<el-input v-model="editForm.data.keyword"></el-input>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="pageurl" prop="pageurl">-->
                <!--<el-input v-model="editForm.data.pageurl">-->
                  <!--<template slot="prepend">http://</template>-->
                <!--</el-input>-->
              <!--</el-form-item>-->
              <!--<el-form-item label="mark" prop="mark">-->
                <!--<el-input type="textarea" :rows="4" v-model="editForm.data.mark"></el-input>-->
              <!--</el-form-item>-->
            <!--</el-card>-->
          <!--</el-col>-->
        </el-row>
      </el-form>
      <span slot="footer" class="dialog-footer">
    <el-button style="width: 100%" type="primary" @click="savePatient('editForm')">S u b m i t</el-button>
    </span>
    </el-dialog>
  </div>
</template>

<script>
  import axios from '../../config/axios'
  import qs from 'qs'
  export default {
    name: 'patient',
    data () {
      return {
        loading: false,
        currentPage: 1,
        patients: {},
        advisories: [],
        channels: [],
        doctors: [],
        diseases: [],
        stateClock: false,
        dialogVisible: false,
        operationState: 'new',
        editForm: {
          data: {
            name: '',
            tel: '',
            date: '',
            advisory: '',
            channel: '',
            doctor: '',
            disease: '',
            age: '',
            sex: '',
            wechat: '',
            keyword: '',
            pageurl: '',
            mark: ''
          },
          rules: {
            name: [
              {required: true, message: 'please enter patient name', trigger: 'blur'}
            ],
            tel: [
              {
                pattern: /^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/,
                message: 'tel error',
                trigger: 'change'
              }
            ],
            age: [
              {required: true, type: 'number', message: 'must number', trigger: 'blur'}
            ],
            date: [
              {type: 'date', required: true, message: 'please select date', trigger: 'change'}
            ]
          }
        }
      }
    },
    computed: {
      patientData () {
        if (!this.patients.data) return []
        let patientData = this.patients.data.map(patient => {
          patient.sex = patient.sex ? 'man' : 'woman'
          return patient
        })
        return patientData
      },
      patientTotal () {
        if (!this.patients) return 0
        return this.patients.total
      }
    },
    methods: {
      addPatient () {
        this.operationState = 'new'
        this.initPatientFormData()
      },
      editPatient (index, row) {
        this.operationState = 'edit'
        this.initPatientFormData('edit', index, row)
      },
      removePatient (index, row) {
        axios.delete(`/patients/${row.id}`)
          .then(res => {
            this.fetchPatients()
          })
      },
      changeState (patientId, patientState) {
        if (this.stateClock) return
        axios.patch(`/patients/${patientId}`, qs.stringify({
          state: patientState
        }))
          .then(res => {
          })
      },
      changePage (currentPage) {
        this.loading = true
        this.stateClock = true
        this.currentPage = currentPage
        this.fetchPatients()
      },
      fetchPatients () {
        let self = this
        !(async function () {
          self.patients = await axios.get(`/patients?page=${self.currentPage}`)
          setTimeout(() => {
            self.stateClock = false
            self.loading = false
          }, 0)
        }())
      },
      initPatientFormData (index = null, row = null) {
        if (this.operationState === 'new') {
          this.editForm.data.name = ''
          this.editForm.data.tel = ''
          this.editForm.data.date = ''
          this.editForm.data.advisory = ''
          this.editForm.data.channel = ''
          this.editForm.data.doctor = ''
          this.editForm.data.disease = ''
          this.editForm.data.doctor = ''
          this.editForm.data.age = ''
          this.editForm.data.sex = ''
          this.editForm.data.wechat = ''
          this.editForm.data.keyword = ''
          this.editForm.data.pageurl = ''
          this.editForm.data.mark = ''
        }
        if (this.operationState === 'edit') {
          this.editForm.data.name = row.name
          this.editForm.data.tel = row.tel
          this.editForm.data.date = row.date
          this.editForm.data.advisory = row.advisory
          this.editForm.data.channel = row.channel
          this.editForm.data.doctor = row.doctor
          this.editForm.data.disease = row.disease
          this.editForm.data.doctor = ''
          this.editForm.data.age = row.age
          this.editForm.data.sex = row.sex
          this.editForm.data.wechat = row.wechat
          this.editForm.data.keyword = row.keyword
          this.editForm.data.pageurl = row.pageurl
          this.editForm.data.mark = row.mark
        }
        this.dialogVisible = true
      },
      savePatient (formName) {
//        let self = this
        if (this.operationState === 'new') {
//          let data = {
//            name: self.editForm.data.name,
//            tel: self.editForm.data.tel,
//            state: 0,
//            advisory_date: self.editForm.data.date,
//          }
//          console.log(oneself.id)
//          axios.post('/patients', qs.stringify({
//            name: self.editForm.data.name,
//            sex: self.editForm.data.sex,
//            age: self.editForm.data.age,
//            tel: self.editForm.data.tel,
//            wechat: self.editForm.data.wechat,
//            state: 0,
//            keyword: self.editForm.data.keyword,
//            pageurl: self.editForm.data.pageurl,
//            price: self.editForm.data.keyword,
//            advisory_date: self.editForm.data.date,
//            keyword: self.editForm.data.keyword,
//          }))
//            .then(res => {
//
//            })
        }
        this.$refs[formName].validate((valid) => {
          if (valid) {
            if (this.operationState === 'new') {
//              let data = {
//                name: self.editForm.data.name,
//                tel: self.editForm.data.tel,
//              }
//          axios.post('/patients', qs.stringify({
//            name: self.editForm.data.name,
//            sex: self.editForm.data.sex,
//            age: self.editForm.data.age,
//            tel: self.editForm.data.tel,
//            wechat: self.editForm.data.wechat,
//            state: 0,
//            keyword: self.editForm.data.keyword,
//            pageurl: self.editForm.data.pageurl,
//            price: self.editForm.data.keyword,
//            advisory_date: self.editForm.data.date,
//            keyword: self.editForm.data.keyword,
//          }))
//            .then(res => {
//
//            })
            }
            this.dialogVisible = false
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      submitForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            alert('submit!')
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      resetForm (formName) {
        this.$refs[formName].resetFields()
      }
    },
    mounted () {
      this.currentPage = 1
      this.fetchPatients()
      if (!this.$store.state.advisories) this.$store.dispatch('getAdvisories')
      if (!this.$store.state.channels) this.$store.dispatch('getChannels')
      if (!this.$store.state.doctors) this.$store.dispatch('getDoctors')
//        self.advisories = advisories.advisories
//        self.channels = channels.channels
//        self.doctors = doctors.doctors
//        for (let disease in diseases.diseases) {
//          self.diseases.push(diseases.diseases[disease])
//        }
//      }())
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 5px;
    }
    .add-doctor {
      margin-bottom: 15px;
    }
  }
</style>
