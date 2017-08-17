<template>
  <div class="channels-data">
    <h2>渠道数据</h2>
    <el-card class="box-card">
      <el-card class="sub-box">
        <el-form class="form-group" :model="channelsForm" ref="channelsForm" :inline="true">
          <el-form-item prop="statisticalType">
            <el-select v-model="channelsForm.statisticalType">
              <el-option label="以年为基准" value="year"></el-option>
              <el-option label="以月为基准" value="month"></el-option>
              <el-option label="以日为基准" value="day"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateType">
            <el-select v-model="channelsForm.dateType">
              <el-option label="创建时间" value="created_at"></el-option>
              <el-option label="到诊时间" value="arrive_date"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="dateRange">
            <el-date-picker
              v-model="channelsForm.dateRange"
              type="daterange"
              :picker-options="pickerOptions"
              format="yyyy-MM-dd">
            </el-date-picker>
          </el-form-item>
          <el-form-item prop="state">
            <el-select v-model="channelsForm.state">
              <el-option :value="0" label="暂未处理"></el-option>
              <el-option :value="1" label="等待"></el-option>
              <el-option :value="2" label="已确认"></el-option>
              <el-option :value="3" label="已取消"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="searchChannelsData('channelsForm')">
              生成数据
            </el-button>
          </el-form-item>
        </el-form>
        <h3>客户数据</h3>
        <el-table :data="channelsData" style="width: 100%">
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
    name: 'channelsData',
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
        channelsForm: {
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
        if (!this.channelsForm.dateRange[0]) return
        return this.channelsForm.dateRange[0].toLocaleDateString().replace(/\//g, '-')
      },
      endDate () {
        if (!this.channelsForm.dateRange[1]) return
        return this.channelsForm.dateRange[1].toLocaleDateString().replace(/\//g, '-')
      },
      col () {
        if (!this.sChannelsData) return []
        let res = []
        Object.keys(this.sChannelsData.data[0]).forEach(item => {
          if (item !== 'date') res.push(item)
        })
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
        let url = `/data/channels?statistical_type=${self.channelsForm.statisticalType}&date_type=${self.channelsForm.dateType}&start_date=${self.startDate}&end_date=${self.endDate}`
        if (/0|1|2|3/.test(self.channelsForm.state.toString())) url += `&state=${self.channelsForm.state}`
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
      searchChannelsData (channelsForm) {
        this.$refs[channelsForm].validate(valid => {
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
  .channels-data {
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
