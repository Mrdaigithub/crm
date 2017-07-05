<template>
  <div class="patient">
    <el-card class="box-card">
      <h2>Patient</h2>
      <el-button type="success" icon="plus" class="add-doctor" @click="addDoctor"></el-button>
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
              <el-option
                v-for="state in patientsState"
                :key="state.value"
                :label="state.label"
                :value="state.value">
              </el-option>
            </el-select>
          </template>
        </el-table-column>
        <el-table-column label="tools" width="200">
          <template scope="scope">
            <el-button size="small" icon="edit" @click="editDialogVisible = true"></el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removePatient(scope.$index, scope.row)"></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination layout="prev, pager, next" :total="patientTotal" :current-page="currentPage"
                     @current-change="changePage"></el-pagination>
    </el-card>
    <el-dialog title="Tips" :visible.sync="editDialogVisible" size="large">
      <el-form :model="editForm.data">
        <el-form-item label="name" prop="name">
          <el-input v-model="editForm.data.name"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button style="width: 100%" type="primary" @click="editDialogVisible = false">确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
  import axios from '../config/axiosConfig'
  import qs from 'qs'

  export default {
    name: 'patient',
    data(){
      return {
        currentPage: 1,
        patients: {},
        patientsState: [
          {value: 0, label: 'untreated'},
          {value: 1, label: 'wait'},
          {value: 2, label: 'confirm'},
          {value: 3, label: 'cancel'}
        ],
        stateClock: false,
        editDialogVisible: false,
        editForm: {
          data: {
            name: '',
            age: 0,
            sex: 0
          }
        }
      }
    },
    computed: {
      patientData(){
        if (!this.patients.data) return [];
        let patientData = this.patients.data.map(patient => {
          patient.sex = patient.sex ? 'man' : 'woman';
          return patient
        })
        return patientData
      },
      patientTotal(){
        if (!this.patients) return 0
        return this.patients.total
      }
    },
    methods: {
      addDoctor(){
        let self = this;
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new doctor name'
        })
          .then(({value}) => {
            axios.get(`/management/doctors/create/${value}`)
              .then(res => {
                self.doctors.push(res.doctor);
              })
          });
      },
      editDoctorName(index, row){
        let self = this;
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Submit',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/doctors/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.doctors.splice(index, 1, res.doctor);
              })
          });
      },
      removePatient(index, row){
        let self = this;
        axios.delete(`/patients/${row.id}`)
          .then(res => {
            this.fetchPatients();
          })
      },
      changeState(patientId, patientState){
        if (this.stateClock) return;
        axios.patch(`/patients/${patientId}`, qs.stringify({
          state: patientState
        }))
          .then(res => {
            console.log(res)
          })
      },
      changePage(currentPage){
        this.stateClock = true;
        this.currentPage = currentPage;
        this.fetchPatients();
      },
      fetchPatients(){
        let self = this;
        !async function () {
          self.patients = await axios.get(`/patients?page=${self.currentPage}`)
          setTimeout(() => {
            self.stateClock = false;
          }, 0)
        }()
      },
    },
    mounted(){
      this.currentPage = 1;
      this.fetchPatients();
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
