<template>
  <div class="channels-data" v-loading.body="$store.state.loading">
    <el-card class="box-card">
      <h2>Channels data</h2>
      <el-card class="sub-box">
         <el-form :model="channelsFrom" ref="channelsFrom" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="channelsFrom.statisticalType">
              <el-option label="year" value="year"></el-option>
              <el-option label="month" value="month"></el-option>
              <el-option label="day" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="channelsFrom.dateType">
              <el-option label="created_at" value="created_at"></el-option>
              <el-option label="arrive_date" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="channelsFrom.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              placeholder="date range"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item prop="state">
            <el-select v-model="channelsFrom.state">
              <el-option :value="0" label="untreated"></el-option>
              <el-option :value="1" label="wait"></el-option>
              <el-option :value="2" label="confirm"></el-option>
              <el-option :value="3" label="cancel"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchChannelsData('channelsFrom')">
              Search
            </el-button>
          </el-form-item>
        </el-form>
        <h3>Patients Data by year</h3>
         <el-table
          :data="channelsData"
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
    name: 'channelsData',
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
        channelsFrom: {
          statisticalType: 'month',
          dateType: 'created_at',
          dateRange: [new Date((new Date()).getTime() - 3600 * 1000 * 24 * 90), new Date()],
          state: ''
        },
        sChannelsData: null,
        chartType: 'bar'
      }
    },
    computed: {
      startDate () {
        if (!this.channelsFrom.dateRange[0]) return
        return this.channelsFrom.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.channelsFrom.dateRange[1]) return
        return this.channelsFrom.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.sChannelsData) return []
        let res = []
        Object.keys(this.sChannelsData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
        res.unshift('date')
        return res
      },
      channelsData () {
        if (!this.sChannelsData) return []
        return this.sChannelsData.data.map((val, index) => {
          val.date = this.sChannelsData.date[index]
          return val
        })
      },
      channelsLegend () {
        return this.col.filter(item => item !== 'date')
      },
      channelsXData () {
        return this.channelsData.map(item => item.date)
      },
      channelsSeries () {
        return this.channelsLegend.map(label => {
          return {
            name: label,
            type: this.chartType,
            data: this.channelsData.map(item => item[label])
          }
        })
      }
    },
    methods: {
      fetchChannelsData () {
        let self = this
        let url = `/data/channels?statistical_type=${self.channelsFrom.statisticalType}&date_type=${self.channelsFrom.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
        if (/0|1|2|3/.test(self.channelsFrom.state.toString())) url += `&state=${self.channelsFrom.state}`
        self.$store.state.loading = true
        axios.get(url)
          .then(res => {
            self.sChannelsData = res
            const channelChart = echarts.init(document.getElementById('yearChart'))
            channelChart.setOption({
              tooltip: {
                trigger: 'axis',
                axisPointer: {
                  type: 'shadow'
                }
              },
              legend: {
                data: self.channelsLegend,
                bottom: 0
              },
              xAxis: {
                data: self.channelsXData
              },
              yAxis: {},
              series: self.channelsSeries
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
      searchChannelsData (channelsFrom) {
        this.$refs[channelsFrom].validate(valid => {
          if (valid) {
            this.fetchChannelsData()
          } else {
            return 'err'
          }
        })
      }
    },
    mounted () {
      this.fetchChannelsData()
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
