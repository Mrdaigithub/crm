<template>
  <div class="total-data">
    <h2>总体数据</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <h3>年数据</h3>
        <el-table stripe :data="yearData">
          <el-table-column
            prop="date"
            label="年份">
          </el-table-column>
          <el-table-column
            prop="advisory"
            label="预约">
          </el-table-column>
          <el-table-column
            prop="arrive"
            label="到诊">
          </el-table-column>
          <el-table-column
            prop="lose"
            label="流失">
          </el-table-column>
          <el-table-column
            label="到诊占比">
            <template scope="scope">
              <p>{{getProportion(scope.row)}}</p>
            </template>
          </el-table-column>
        </el-table>
        <div id="yearChart"></div>
      </el-card>
      <el-card class="sub-box">
        <h3>月数据</h3>
        <el-table stripe :data="monthData">
          <el-table-column
            prop="date"
            label="月份">
          </el-table-column>
          <el-table-column
            prop="advisory"
            label="预约">
          </el-table-column>
          <el-table-column
            prop="arrive"
            label="到诊">
          </el-table-column>
          <el-table-column
            prop="lose"
            label="流失">
          </el-table-column>
          <el-table-column
            label="到诊占比">
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
            data: ['预约', '到诊', '流失'],
            bottom: 0
          },
          xAxis: {
            data: self.yearXData
          },
          yAxis: {},
          series: [
            {
              name: '预约',
              type: 'bar',
              data: self.yearSeriesAdvisory
            },
            {
              name: '到诊',
              type: 'bar',
              data: self.yearSeriesArrive
            },
            {
              name: '流失',
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
            data: ['预约', '到诊', '流失'],
            bottom: 0
          },
          xAxis: {
            data: self.monthXData
          },
          yAxis: {},
          series: [
            {
              name: '预约',
              type: 'bar',
              data: self.monthSeriesAdvisory
            },
            {
              name: '到诊',
              type: 'bar',
              data: self.monthSeriesArrive
            },
            {
              name: '流失',
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
