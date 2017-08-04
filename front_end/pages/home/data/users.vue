<template>
  <div class="users-data" v-loading.body="$store.state.loading">
    <h2>Users data</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <el-form :model="userFrom" ref="userFrom" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="userFrom.statisticalType">
              <el-option label="year" value="year"></el-option>
              <el-option label="month" value="month"></el-option>
              <el-option label="day" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="userFrom.dateType">
              <el-option label="created_at" value="created_at"></el-option>
              <el-option label="arrive_date" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="userFrom.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              placeholder="date range"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item prop="state">
            <el-select v-model="userFrom.state">
              <el-option :value="0" label="untreated"></el-option>
              <el-option :value="1" label="wait"></el-option>
              <el-option :value="2" label="confirm"></el-option>
              <el-option :value="3" label="cancel"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchUserData('userFrom')">
              Search
            </el-button>
          </el-form-item>
        </el-form>
        <h3>Patients Data by year</h3>
        <el-table
          :data="usersData"
          style="width: 100%">
          <el-table-column
            v-for="key in col"
            :key="key"
            :prop="key"
            :label="key">
          </el-table-column>
          <el-table-column
            label="Sum" fixed="right">
            <template scope="scope">
              <p>{{getSum(scope.row)}}</p>
            </template>
          </el-table-column>
        </el-table>
        <div id="yearChart"></div>
      </el-card>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../../config/axios'

  const echarts = require('echarts')

  export default {
    name: 'usersData',
    data () {
      return {
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
        },
        userFrom: {
          statisticalType: 'month',
          dateType: 'created_at',
          dateRange: [new Date((new Date()).getTime() - 3600 * 1000 * 24 * 90), new Date()],
          state: ''
        },
        sUsersData: null,
        chartType: 'bar'
      }
    },
    computed: {
      startDate () {
        if (!this.userFrom.dateRange[0]) return
        return this.userFrom.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.userFrom.dateRange[1]) return
        return this.userFrom.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.sUsersData) return []
        let res = []
        Object.keys(this.sUsersData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
        res.unshift('date')
        return res
      },
      usersData () {
        if (!this.sUsersData) return []
        return this.sUsersData.data.map((val, index) => {
          val.date = this.sUsersData.date[index]
          return val
        })
      },
      usersLegend () {
        return this.col.filter(item => item !== 'date')
      },
      usersXData () {
        return this.usersData.map(item => item.date)
      },
      usersSeries () {
        return this.usersLegend.map(label => {
          return {
            name: label,
            type: this.chartType,
            data: this.usersData.map(item => item[label])
          }
        })
      }
    },
    methods: {
      fetchUserData () {
        let self = this
        let url = `/data/users?statistical_type=${self.userFrom.statisticalType}&date_type=${self.userFrom.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
        if (/0|1|2|3/.test(self.userFrom.state.toString())) url += `&state=${self.userFrom.state}`
        self.$store.state.loading = true
        axios.get(url)
          .then(res => {
            self.sUsersData = res
            const userChart = echarts.init(document.getElementById('yearChart'))
            userChart.setOption({
              tooltip: {
                trigger: 'axis',
                axisPointer: {
                  type: 'shadow'
                }
              },
              legend: {
                data: self.usersLegend,
                bottom: 0
              },
              xAxis: {
                data: self.usersXData
              },
              yAxis: {},
              series: self.usersSeries
            })
            self.$store.state.loading = false
          })
      },
      getSum (data) {
        let sum = 0
        for (let key in data) {
          if (key === 'date') continue
          sum += data[key]
        }
        return sum
      },
      searchUserData (userFrom) {
        this.$refs[userFrom].validate(valid => {
          if (valid) {
            this.fetchUserData()
          } else {
            return 'err'
          }
        })
      }
    },
    mounted () {
      this.fetchUserData()
    }
  }
</script>

<style scoped lang="scss">
  .users-data {
    .sub-box {
      margin: 40px 0;
      h3 {
        margin-top: 40px;
        margin-bottom: 15px;
      }
      #yearChart, #monthChart {
        height: 400px;
      }
    }
  }
</style>
