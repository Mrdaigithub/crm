<template>
  <div class="total-data">
    <h2>Total data</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <h3>Patients Data by year</h3>
        <el-table stripe :data="yearData">
          <el-table-column
            prop="date"
            label="date">
          </el-table-column>
          <el-table-column
            prop="advisory"
            label="advisory patients">
          </el-table-column>
          <el-table-column
            prop="arrive"
            label="arrive patients">
          </el-table-column>
          <el-table-column
            prop="lose"
            label="lose patients">
          </el-table-column>
          <el-table-column
            label="proportion">
            <template scope="scope">
              <p>{{getProportion(scope.row)}}</p>
            </template>
          </el-table-column>
        </el-table>
        <div id="yearChart"></div>
      </el-card>
      <el-card class="sub-box">
        <h3>Patients Data by month</h3>
        <el-table stripe :data="monthData">
          <el-table-column
            prop="date"
            label="date">
          </el-table-column>
          <el-table-column
            prop="advisory"
            label="advisory patients">
          </el-table-column>
          <el-table-column
            prop="arrive"
            label="arrive patients">
          </el-table-column>
          <el-table-column
            prop="lose"
            label="lose patients">
          </el-table-column>
          <el-table-column
            label="proportion">
            <template scope="scope">
              <p>{{getProportion(scope.row)}}</p>
            </template>
          </el-table-column>
        </el-table>
        <div id="monthChart"></div>
      </el-card>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../../config/axios'

  const echarts = require('echarts')

  export default {
    name: 'totalData',
    data () {
      return {
        yearData: [],
        monthData: []
      }
    },
    computed: {
      yearXData () {
        if (!this.yearData || !this.yearData.length) return []
        return this.yearData.map(item => item.date)
      },
      yearSeriesAdvisory () {
        if (!this.yearData || !this.yearData.length) return []
        return this.yearData.map(item => item.advisory)
      },
      yearSeriesArrive () {
        if (!this.yearData || !this.yearData.length) return []
        return this.yearData.map(item => item.arrive)
      },
      yearSeriesLose () {
        if (!this.yearData || !this.yearData.length) return []
        return this.yearData.map(item => item.lose)
      },
      monthXData () {
        if (!this.monthData || !this.monthData.length) return []
        return this.monthData.map(item => item.date)
      },
      monthSeriesAdvisory () {
        if (!this.monthData || !this.monthData.length) return []
        return this.monthData.map(item => item.advisory)
      },
      monthSeriesArrive () {
        if (!this.monthData || !this.monthData.length) return []
        return this.monthData.map(item => item.arrive)
      },
      monthSeriesLose () {
        if (!this.monthData || !this.monthData.length) return []
        return this.monthData.map(item => item.lose)
      }
    },
    methods: {
      getProportion (data) {
        if (data['advisory'] === 0) return '0.00%'
        return `${((data['arrive'] / data['advisory']) * 100).toFixed(2)}%`
      }
    },
    mounted () {
      let self = this
      !(async function () {
        [
          self.yearData,
          self.monthData
        ] = await Promise.all([
          axios.get('/data/total/year'),
          axios.get('/data/total/month')
        ])
        self.$store.state.loading = false
        const yearChart = echarts.init(document.getElementById('yearChart'))
        const monthChart = echarts.init(document.getElementById('monthChart'))
        yearChart.setOption({
          tooltip: {
            trigger: 'axis',
            axisPointer: {
              type: 'shadow'
            }
          },
          legend: {
            data: ['Advisory', 'Arrive', 'Lose'],
            bottom: 0
          },
          xAxis: {
            data: self.yearXData
          },
          yAxis: {},
          series: [
            {
              name: 'Advisory',
              type: 'bar',
              data: self.yearSeriesAdvisory
            },
            {
              name: 'Arrive',
              type: 'bar',
              data: self.yearSeriesArrive
            },
            {
              name: 'Lose',
              type: 'bar',
              data: self.yearSeriesLose
            }
          ]
        })
        monthChart.setOption({
          tooltip: {
            trigger: 'axis',
            axisPointer: {
              type: 'shadow'
            }
          },
          legend: {
            data: ['Advisory', 'Arrive', 'Lose'],
            bottom: 0
          },
          xAxis: {
            data: self.monthXData
          },
          yAxis: {},
          series: [
            {
              name: 'Advisory',
              type: 'bar',
              data: self.monthSeriesAdvisory
            },
            {
              name: 'Arrive',
              type: 'bar',
              data: self.monthSeriesArrive
            },
            {
              name: 'Lose',
              type: 'bar',
              data: self.monthSeriesLose
            }
          ]
        })
      })()
    }
  }
</script>

<style scoped lang="scss">
  .total-data {
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
