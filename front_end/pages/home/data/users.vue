<template>
  <div class="users-data">
    <h2>用户数据</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <el-form class="form-group" :model="userForm" ref="userForm" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="userForm.statisticalType">
              <el-option label="以年为基准" value="year"></el-option>
              <el-option label="以月为基准" value="month"></el-option>
              <el-option label="以日为基准" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="userForm.dateType">
              <el-option label="创建时间" value="created_at"></el-option>
              <el-option label="到诊时间" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="userForm.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item prop="state">
            <el-select v-model="userForm.state">
              <el-option :value="0" label="暂未处理"></el-option>
              <el-option :value="1" label="等待"></el-option>
              <el-option :value="2" label="已确认"></el-option>
              <el-option :value="3" label="已取消"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchUserData('userForm')">
              生成数据
            </el-button>
          </el-form-item>
        </el-form>
        <h3>客户数据</h3>
        <el-table :data="usersData" style="width: 100%">
          <el-table-column prop="date" label="日期"></el-table-column>
          <el-table-column
            v-for="key in col"
            :key="key"
            :prop="key"
            :label="key">
          </el-table-column>
          <el-table-column label="总计" fixed="right">
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
            text: '一周',
            onClick (picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: '一个月',
            onClick (picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: '三个月',
            onClick (picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
              picker.$emit('pick', [start, end])
            }
          }]
        },
        userForm: {
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
        if (!this.userForm.dateRange[0]) return
        return this.userForm.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.userForm.dateRange[1]) return
        return this.userForm.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.sUsersData) return []
        let res = []
        Object.keys(this.sUsersData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
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
        let url = `/data/users?statistical_type=${self.userForm.statisticalType}&date_type=${self.userForm.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
        if (/0|1|2|3/.test(self.userForm.state.toString())) url += `&state=${self.userForm.state}`
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
      searchUserData (userForm) {
        this.$refs[userForm].validate(valid => {
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
        margin-bottom: 15px;
      }
      #yearChart, #monthChart {
        height: 400px;
      }
    }
  }
</style>
