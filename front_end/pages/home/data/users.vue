<template>
  <div class="users-data" v-loading.body="$store.state.loading">
    <el-card class="box-card">
      <h2>Users data</h2>
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
              placeholder="date range">
            </el-date-picker>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="userFrom.state">
              <el-option label="created_at" value="created_at"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="search('loginFrom')">
              Search
            </el-button>
          </el-form-item>
        </el-form>
        <h3>Patients Data by year</h3>
        <!--<el-table stripe :data="yearData">-->
        <!--<el-table-column-->
        <!--prop="date"-->
        <!--label="date">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
        <!--prop="advisory"-->
        <!--label="advisory patients">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
        <!--prop="arrive"-->
        <!--label="arrive patients">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
        <!--prop="lose"-->
        <!--label="lose patients">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
        <!--label="proportion">-->
        <!--<template scope="scope">-->
        <!--<p>{{getProportion(scope.row)}}</p>-->
        <!--</template>-->
        <!--</el-table-column>-->
        <!--</el-table>-->
        <!--<div id="yearChart"></div>-->
      </el-card>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../../config/axios'

  //  const echarts = require('echarts')

  export default {
    name: 'usersData',
    data () {
      return {
        userFrom: {
          statisticalType: 'month',
          dateType: 'created_at',
          dateRange: ''
        },
        yearData: []
      }
    },
    computed: {
//      yearXData () {
//        if (!this.yearData || !this.yearData.length) return []
//        return this.yearData.map(item => item.date)
//      },
//      yearSeriesAdvisory () {
//        if (!this.yearData || !this.yearData.length) return []
//        return this.yearData.map(item => item.advisory)
//      },
//      yearSeriesArrive () {
//        if (!this.yearData || !this.yearData.length) return []
//        return this.yearData.map(item => item.arrive)
//      },
//      yearSeriesLose () {
//        if (!this.yearData || !this.yearData.length) return []
//        return this.yearData.map(item => item.lose)
//      }
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
          axios.get('/data/total/year')
        ])
        self.$store.state.loading = false
//        const yearChart = echarts.init(document.getElementById('yearChart'))
//        yearChart.setOption({
//          tooltip: {
//            trigger: 'axis',
//            axisPointer: {
//              type: 'shadow'
//            }
//          },
//          legend: {
//            data: ['Advisory', 'Arrive', 'Lose'],
//            bottom: 0
//          },
//          xAxis: {
//            data: self.yearXData
//          },
//          yAxis: {},
//          series: [
//            {
//              name: 'Advisory',
//              type: 'bar',
//              data: self.yearSeriesAdvisory
//            },
//            {
//              name: 'Arrive',
//              type: 'bar',
//              data: self.yearSeriesArrive
//            },
//            {
//              name: 'Lose',
//              type: 'bar',
//              data: self.yearSeriesLose
//            }
//          ]
//        })
      })()
    }
  }
</script>

<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 25px;
    }
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
