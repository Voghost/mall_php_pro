<template>
  <div class="dashboard-editor-container">

    <panel-group @handleSetLineChartData="handleSetLineChartData" />

    <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">
      <line-chart :chart-data="lineChartData" />
    </el-row>

    <el-row :gutter="8">
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 12}" :xl="{span: 12}" style="padding-right:8px;margin-bottom:30px;">
        <transaction-table />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 12}" :xl="{span: 12}" style="padding-right:8px;margin-bottom:30px;">
        <comment-table />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PanelGroup from './PanelGroup'
import LineChart from './LineChart'
import TransactionTable from './TransactionTable'
import CommentTable from './CommentTable'
import echartApi from '@/api/echart'

export default{
  components: {
    LineChart,
    PanelGroup,
    TransactionTable,
    CommentTable
  },
  data(){
    return {
      count: 0,
      line: {
        newVisitis: {
          expectedData: {}
        },
        messages: {
          expectedData: {}
        },
        purchases: {
          expectedData: {}
        },
        shoppings: {
          expectedData: {}
        }
      },
      lineChartData: {}
    }
  },
  methods: {
    handleSetLineChartData(type) {
      this.lineChartData = this.line[type]
    },
    getChart(){
      echartApi.getWeekData()
        .then(response =>{
          console.log(response.data[0]);
          this.line.newVisitis.expectedData = response.data[0].user
          this.line.messages.expectedData = response.data[0].comment
          this.line.purchases.expectedData = response.data[0].price
          this.line.shoppings.expectedData = response.data[0].order
          if(this.count++ === 0){
            this.lineChartData = this.line.newVisitis
          }
        })
    }
  },
  created() {
    this.getChart()
    setInterval(this.getChart, 20000)
  }
}
</script>

<style lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  position: relative;

  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}

@media (max-width:1024px) {
  .chart-wrapper {
    padding: 8px;
  }
}
</style>
