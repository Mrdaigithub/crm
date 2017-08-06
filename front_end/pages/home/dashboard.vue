<template>
  <div class="dashboard">
    <h2>Dashboard</h2>
    <main>
      <el-row type="flex" justify="space-between" class="top-card-list">
        <el-col class="top-card-item">
          <h4 class="title">本月预约</h4>
          <div class="clearfix">
            <i class="pull-left el-icon-ali-reserve"></i>
            <span class="pull-right">{{stateData.untreated}}</span>
          </div>
        </el-col>
        <el-col class="top-card-item">
          <h4 class="title">本月实到</h4>
          <div class="cleafix">
            <i class="pull-left el-icon-ali-arrive"></i>
            <span class="pull-right">{{stateData.confirm}}</span>
          </div>
        </el-col>
        <el-col class="top-card-item">
          <h4 class="title">本月取消</h4>
          <div class="cleafix">
            <i class="pull-left el-icon-ali-cancel"></i>
            <span class="pull-right">{{stateData.cancel}}</span>
          </div>
        </el-col>
        <el-col class="top-card-item">
          <h4 class="title">本月实到率</h4>
          <div class="cleafix">
            <i class="pull-left el-icon-ali-proportion"></i>
            <span class="pull-right">
              {{((stateData.confirm / stateData.untreated) ? 0 : (stateData.confirm / stateData.untreated)) + '%'}}
            </span>
          </div>
        </el-col>
      </el-row>
      <el-row type="flex" justify="space-between" class="charts-card-list">
        <el-col class="round-chart-wrap">
          <div id="roundChart"></div>
        </el-col>
        <el-col class="line-chart-wrap">
          <div id="lineChart"></div>
        </el-col>
      </el-row>
      <el-row type="flex" justify="space-between" class="bottom-card-list">
        <el-col class="total-chart-wrap">
          <div id="totalChart"></div>
        </el-col>
        <el-col class="total-table-wrap">
          <h3>数据统计表</h3>
          <el-table :data="totalTableData" border>
            <el-table-column prop="date" label="日期"></el-table-column>
            <el-table-column prop="untreated" label="预约"></el-table-column>
            <el-table-column prop="confirm" label="已到"></el-table-column>
            <el-table-column prop="cancel" label="未到"></el-table-column>
          </el-table>
        </el-col>
      </el-row>
    </main>
  </div>
</template>

<script>
  import axios from '../../config/axios'

  const echarts = require('echarts')

  export default {
    name: 'dashboard',
    data () {
      return {
        sStateData: null,
        sChannelsData: null,
        sLineStateData: null,
        todayData: null,
        yesterdayData: null,
        lastMonthData: null
      }
    },
    computed: {
      stateData () {
        if (!this.sStateData) {
          return {
            untreated: 0,
            wait: 0,
            confirm: 0,
            cancel: 0
          }
        }
        return {
          untreated: this.sStateData.data[0].untreated,
          wait: this.sStateData.data[0].wait,
          confirm: this.sStateData.data[0].confirm,
          cancel: this.sStateData.data[0].cancel
        }
      },
      channelsCol () {
        let res = []
        if (!this.sChannelsData) return []
        for (let channelData in this.sChannelsData.data[0]) {
          res.push(channelData)
        }
        return res
      },
      channelsData () {
        let res = []
        if (!this.sChannelsData) return []
        for (let channelData in this.sChannelsData.data[0]) {
          res.push({name: channelData, value: this.sChannelsData.data[0][channelData]})
        }
        return res
      },
      lineStateXData () {
        if (!this.sLineStateData) return []
        return this.sLineStateData.date.map(item => {
          return item.substring(5)
        })
      },
      lineStateSeriesData () {
        let res = []
        if (!this.sLineStateData) return []
        res.push(this.sLineStateData.data.map(item => item.untreated))
        res.push(this.sLineStateData.data.map(item => item.confirm))
        res.push(this.sLineStateData.data.map(item => item.cancel))
        return res
      },
      monthData () {
        return this.sStateData
      },
      totalTableData () {
        if (!this.todayData || !this.yesterdayData || !this.monthData || !this.lastMonthData) return []
        return [{
          date: '今天',
          untreated: this.todayData.data[0].untreated,
          confirm: this.todayData.data[0].confirm,
          cancel: this.todayData.data[0].cancel
        }, {
          date: '昨天',
          untreated: this.yesterdayData.data[0].untreated,
          confirm: this.yesterdayData.data[0].confirm,
          cancel: this.yesterdayData.data[0].cancel
        }, {
          date: '本月',
          untreated: this.monthData.data[0].untreated,
          confirm: this.monthData.data[0].confirm,
          cancel: this.monthData.data[0].cancel
        }, {
          date: '上月',
          untreated: this.lastMonthData.data[0].untreated,
          confirm: this.lastMonthData.data[0].confirm,
          cancel: this.lastMonthData.data[0].cancel
        }, {
          date: '环比增长率',
          untreated: this.lastMonthData.data[0].untreated === 0 ? '上月暂无数据' : ((this.monthData.data[0].untreated - this.lastMonthData.data[0].untreated) / this.lastMonthData.data[0].untreated * 100) + '%',
          confirm: this.lastMonthData.data[0].confirm === 0 ? '上月暂无数据' : ((this.monthData.data[0].confirm - this.lastMonthData.data[0].confirm) / this.lastMonthData.data[0].confirm * 100) + '%',
          cancel: this.lastMonthData.data[0].cancel === 0 ? '上月暂无数据' : ((this.monthData.data[0].cancel - this.lastMonthData.data[0].cancel) / this.lastMonthData.data[0].cancel * 100) + '%'
        }]
      },
      totalChartData () {
        return [
          [this.todayData.data[0].untreated, this.yesterdayData.data[0].untreated, this.monthData.data[0].untreated, this.lastMonthData.data[0].untreated],
          [this.todayData.data[0].confirm, this.yesterdayData.data[0].confirm, this.monthData.data[0].confirm, this.lastMonthData.data[0].confirm],
          [this.todayData.data[0].cancel, this.yesterdayData.data[0].cancel, this.monthData.data[0].cancel, this.lastMonthData.data[0].cancel]
        ]
      }
    },
    mounted () {
      let self = this
      let date = new Date()
      let yesterdayDate = new Date(date.getTime() - (24 * 3600 * 1000))
      !(async function () {
        [
          self.sChannelsData,
          self.sStateData,
          self.sLineStateData,
          self.todayData,
          self.yesterdayData,
          self.lastMonthData
        ] = await Promise.all([
          axios.get(`http://crm.mrdaisite.com/api/data/channels?statistical_type=month&date_type=created_at&start_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-1'}&end_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()}`),
          axios.get(`http://crm.mrdaisite.com/api/data/patients?statistical_type=month&date_type=created_at&start_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-1'}&end_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()}`),
          axios.get(`http://crm.mrdaisite.com/api/data/patients?statistical_type=day&date_type=created_at&start_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-1'}&end_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()}`),
          axios.get(`http://crm.mrdaisite.com/api/data/patients?statistical_type=day&date_type=created_at&start_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()}&end_date=${date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()}`),
          axios.get(`http://crm.mrdaisite.com/api/data/patients?statistical_type=day&date_type=created_at&start_date=${yesterdayDate.getFullYear() + '-' + (yesterdayDate.getMonth() + 1) + '-' + yesterdayDate.getDate()}&end_date=${yesterdayDate.getFullYear() + '-' + (yesterdayDate.getMonth() + 1) + '-' + yesterdayDate.getDate()}`),
          axios.get(`http://crm.mrdaisite.com/api/data/patients?statistical_type=month&date_type=created_at&start_date=${date.getFullYear() + '-' + date.getMonth() + '-1'}&end_date=${date.getFullYear() + '-' + date.getMonth() + '-31'}`)
        ])
        self.$store.state.loading = false
        let roundChart = echarts.init(document.querySelector('#roundChart'))
        let lineChart = echarts.init(document.querySelector('#lineChart'))
        let chart = echarts.init(document.querySelector('#totalChart'))
        roundChart.setOption({
          title: {
            text: '本月渠道来源占比',
            textStyle: {
              fontWeight: 500,
              fontSize: 14
            }
          },
          tooltip: {
            trigger: 'item'
          },
          legend: {
            orient: 'horizontal',
            bottom: 0,
            data: self.channelsCol
          },
          series: [
            {
              name: '渠道来源',
              type: 'pie',
              radius: ['50%', '70%'],
              avoidLabelOverlap: false,
              label: {
                normal: {
                  show: false,
                  position: 'center'
                },
                emphasis: {
                  show: true,
                  textStyle: {
                    fontSize: '30',
                    fontWeight: 'normal'
                  }
                }
              },
              labelLine: {
                normal: {
                  show: false
                }
              },
              data: self.channelsData
            }
          ]
        })
        lineChart.setOption({
          title: {
            text: '本月汇总',
            textStyle: {
              fontWeight: 500,
              fontSize: 14
            }
          },
          tooltip: {
            trigger: 'axis',
            axisPointer: {
              type: 'cross',
              label: {
                backgroundColor: '#6a7985'
              }
            }
          },
          legend: {
            top: 40,
            data: ['预约', '已到', '未到']
          },
          grid: {
            top: 90,
            left: '3%',
            right: '4%',
            bottom: 0,
            containLabel: true
          },
          xAxis: [
            {
              type: 'category',
              boundaryGap: false,
              data: self.lineStateXData
            }
          ],
          yAxis: [
            {
              type: 'value'
            }
          ],
          series: [
            {
              name: '预约',
              type: 'line',
              stack: '总量',
              areaStyle: {normal: {}},
              data: self.lineStateSeriesData[0]
            },
            {
              name: '已到',
              type: 'line',
              stack: '总量',
              areaStyle: {normal: {}},
              data: self.lineStateSeriesData[1]
            },
            {
              name: '未到',
              type: 'line',
              stack: '总量',
              areaStyle: {normal: {}},
              data: self.lineStateSeriesData[2]
            }
          ]
        })
        chart.setOption({
          title: {
            text: '数据统计视图',
            textStyle: {
              fontWeight: 500,
              fontSize: 14
            }
          },
          tooltip: {
            trigger: 'axis',
            axisPointer: {
              type: 'shadow'
            }
          },
          legend: {
            right: 0,
            data: ['预约', '已到', '未到']
          },
          grid: {
            left: '3%',
            right: '4%',
            bottom: 0,
            containLabel: true
          },
          xAxis: {
            data: ['今天', '昨天', '本月', '上月']
          },
          yAxis: {},
          series: [
            {
              name: '预约',
              type: 'bar',
              data: self.totalChartData[0]
            },
            {
              name: '已到',
              type: 'bar',
              data: self.totalChartData[1]
            },
            {
              name: '未到',
              type: 'bar',
              data: self.totalChartData[2]
            }
          ]
        })
      })()
    }
  }
</script>

<style lang="scss">
  .dashboard {
    main {
      padding: 25px;
      .top-card-list {
        .top-card-item {
          width: 24%;
          background: #fff;
          padding: 25px;
          margin-bottom: 15px;
          .title {
            margin: 0 0 30px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
            color: #2b2b2b;
            font-family: Poppins, sans-serif;
          }
          .clearfix {
            margin-bottom: 10px;
          }
          span {
            font-size: 36px;
            font-weight: 100;
          }
          i {
            font-size: 36px;
          }
        }
        .top-card-item:nth-child(1) {
          i {
            color: #03a9f3;
          }
        }
        .top-card-item:nth-child(2) {
          i {
            color: #9675ce;
          }
        }
        .top-card-item:nth-child(3) {
          i {
            color: #fb9678;
          }
        }
        .top-card-item:nth-child(4) {
          i {
            color: #00c292;
          }
        }
      }
      .charts-card-list {
        .round-chart-wrap, .line-chart-wrap {
          background: #fff;
          padding: 25px;
          margin-bottom: 15px;
          #roundChart, #lineChart {
            height: 450px;
          }
        }
        .round-chart-wrap {
          width: 40%;
        }
        .line-chart-wrap {
          width: 58.5%;
        }
      }
      .bottom-card-list {
        .total-chart-wrap, .total-table-wrap {
          width: 49.2%;
          background: #fff;
          padding: 25px;
          margin-bottom: 15px;
        }
        .total-table-wrap {
          h3 {
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 30px;
          }
        }
        .total-chart-wrap {
          #totalChart {
            height: 300px;
          }
        }
      }
    }
  }
</style>
