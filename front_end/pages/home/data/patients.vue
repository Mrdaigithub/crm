<template>
  <div class="patients-data">
    <h2>客户状态数据</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <el-form class="form-group" :model="patientsForm" ref="patientsForm" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="patientsForm.statisticalType">
              <el-option label="以年为基准" value="year"></el-option>
              <el-option label="以月为基准" value="month"></el-option>
              <el-option label="以日为基准" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="patientsForm.dateType">
              <el-option label="创建时间" value="created_at"></el-option>
              <el-option label="到诊时间" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="patientsForm.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchpatientsData('patientsForm')">
              生成数据
            </el-button>
          </el-form-item>
        </el-form>
        <h3>客户数据</h3>
        <el-table :data="patientsData" style="width: 100%">
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
    name: 'patientsData',
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
        patientsForm: {
          statisticalType: 'month',
          dateType: 'created_at',
          dateRange: [new Date((new Date()).getTime() - 3600 * 1000 * 24 * 90), new Date()]
        },
        spatientsData: null,
        chartType: 'bar'
      }
    },
    computed: {
      startDate () {
        if (!this.patientsForm.dateRange[0]) return
        return this.patientsForm.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.patientsForm.dateRange[1]) return
        return this.patientsForm.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.spatientsData) return []
        let res = []
        Object.keys(this.spatientsData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
        return res
      },
      patientsData () {
        if (!this.spatientsData) return []
        return this.spatientsData.data.map((val, index) => {
          val.date = this.spatientsData.date[index]
          return val
        })
      },
      patientsLegend () {
        return this.col.filter(item => item !== 'date')
      },
      patientsXData () {
        return this.patientsData.map(item => item.date)
      },
      patientsSeries () {
        return this.patientsLegend.map(label => {
          return {
            name: label,
            type: this.chartType,
            data: this.patientsData.map(item => item[label])
          }
        })
      }
    },
    methods: {
      fetchpatientsData () {
        let self = this
        let url = `/data/patients?statistical_type=${self.patientsForm.statisticalType}&date_type=${self.patientsForm.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
        self.$store.state.loading = true
        axios.get(url)
          .then(res => {
            self.spatientsData = res
            const patientChart = echarts.init(document.getElementById('yearChart'))
            patientChart.setOption({
              tooltip: {
                trigger: 'axis',
                axisPointer: {
                  type: 'shadow'
                }
              },
              legend: {
                data: self.patientsLegend,
                bottom: 0
              },
              xAxis: {
                data: self.patientsXData
              },
              yAxis: {},
              series: self.patientsSeries
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
      searchpatientsData (patientsForm) {
        this.$refs[patientsForm].validate(valid => {
          if (valid) {
            this.fetchpatientsData()
          } else {
            return 'err'
          }
        })
      }
    },
    mounted () {
      this.fetchpatientsData()
    }
  }
</script>

<style scoped lang="scss">
  .patients-data {
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
