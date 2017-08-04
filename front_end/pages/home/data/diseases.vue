<template>
  <div class="diseases-data">
    <h2>Diseases data</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <el-form :model="diseasesFrom" ref="diseasesFrom" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="diseasesFrom.statisticalType">
              <el-option label="year" value="year"></el-option>
              <el-option label="month" value="month"></el-option>
              <el-option label="day" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="diseasesFrom.dateType">
              <el-option label="created_at" value="created_at"></el-option>
              <el-option label="arrive_date" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="diseasesFrom.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              placeholder="date range"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item prop="state">
            <el-select v-model="diseasesFrom.state">
              <el-option :value="0" label="untreated"></el-option>
              <el-option :value="1" label="wait"></el-option>
              <el-option :value="2" label="confirm"></el-option>
              <el-option :value="3" label="cancel"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchDiseasesData('diseasesFrom')">
              Search
            </el-button>
          </el-form-item>
        </el-form>
        <h3>Patients Data by year</h3>
        <el-table
          :data="diseasesData"
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
    name: 'diseasesData',
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
        diseasesFrom: {
          statisticalType: 'month',
          dateType: 'created_at',
          dateRange: [new Date((new Date()).getTime() - 3600 * 1000 * 24 * 90), new Date()],
          state: ''
        },
        sdiseasesData: null,
        chartType: 'bar'
      }
    },
    computed: {
      startDate () {
        if (!this.diseasesFrom.dateRange[0]) return
        return this.diseasesFrom.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.diseasesFrom.dateRange[1]) return
        return this.diseasesFrom.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.sdiseasesData) return []
        let res = []
        Object.keys(this.sdiseasesData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
        res.unshift('date')
        return res
      },
      diseasesData () {
        if (!this.sdiseasesData) return []
        return this.sdiseasesData.data.map((val, index) => {
          val.date = this.sdiseasesData.date[index]
          return val
        })
      },
      diseasesLegend () {
        return this.col.filter(item => item !== 'date')
      },
      diseasesXData () {
        return this.diseasesData.map(item => item.date)
      },
      diseasesSeries () {
        return this.diseasesLegend.map(label => {
          return {
            name: label,
            type: this.chartType,
            data: this.diseasesData.map(item => item[label])
          }
        })
      }
    },
    methods: {
      fetchDiseasesData () {
        let self = this
        let url = `/data/diseases?statistical_type=${self.diseasesFrom.statisticalType}&date_type=${self.diseasesFrom.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
        if (/0|1|2|3/.test(self.diseasesFrom.state.toString())) url += `&state=${self.diseasesFrom.state}`
        self.$store.state.loading = true
        axios.get(url)
          .then(res => {
            self.sdiseasesData = res
            const diseaseChart = echarts.init(document.getElementById('yearChart'))
            diseaseChart.setOption({
              tooltip: {
                trigger: 'axis',
                axisPointer: {
                  type: 'shadow'
                }
              },
              legend: {
                data: self.diseasesLegend,
                bottom: 0
              },
              xAxis: {
                data: self.diseasesXData
              },
              yAxis: {},
              series: self.diseasesSeries
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
      searchDiseasesData (diseasesFrom) {
        this.$refs[diseasesFrom].validate(valid => {
          if (valid) {
            this.fetchDiseasesData()
          } else {
            return 'err'
          }
        })
      }
    },
    mounted () {
      this.fetchDiseasesData()
    }
  }
</script>

<style scoped lang="scss">
  .diseases-data {
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
