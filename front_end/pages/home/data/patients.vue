<template>
  <div class="patients-data">
    <h2>patients data</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <el-form :model="patientsFrom" ref="patientsFrom" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="patientsFrom.statisticalType">
              <el-option label="year" value="year"></el-option>
              <el-option label="month" value="month"></el-option>
              <el-option label="day" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="patientsFrom.dateType">
              <el-option label="created_at" value="created_at"></el-option>
              <el-option label="arrive_date" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="patientsFrom.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              placeholder="date range"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchpatientsData('patientsFrom')">
              Search
            </el-button>
          </el-form-item>
        </el-form>
        <h3>Patients Data by year</h3>
        <el-table
          :data="patientsData"
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
    name: 'patientsData',
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
        patientsFrom: {
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
        if (!this.patientsFrom.dateRange[0]) return
        return this.patientsFrom.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.patientsFrom.dateRange[1]) return
        return this.patientsFrom.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.spatientsData) return []
        let res = []
        Object.keys(this.spatientsData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
        res.unshift('date')
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
        let url = `/data/patients?statistical_type=${self.patientsFrom.statisticalType}&date_type=${self.patientsFrom.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
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
      searchpatientsData (patientsFrom) {
        this.$refs[patientsFrom].validate(valid => {
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
        margin-top: 40px;
        margin-bottom: 15px;
      }
      #yearChart, #monthChart {
        height: 400px;
      }
    }
  }
</style>
