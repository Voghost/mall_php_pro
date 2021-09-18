<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item label="订单编号">
        <el-input v-model="searchObj.order_number" placeholder="订单编号"/>
      </el-form-item>
      <el-date-picker
        v-model="searchObj.Datevalue"
        type="daterange"
        align="right"
        unlink-panels
        range-separator="至"
        start-placeholder="开始日期"
        end-placeholder="结束日期"
        format="yyyy年MM月dd日"
        value-format="yyyy-MM-dd"
        :picker-options="pickerOptions">
      </el-date-picker>
      <el-form-item class="bttn">
        <el-button type="primary" @click="getList()">查询</el-button>
      </el-form-item>
    </el-form>
    <el-table
      :data="tableData"
      stripe
      border
      style="width: 100%"
      @sort-change="handleSortChange"
      :default-sort="{prop: 'order_id', order: 'ascending'}"
    >
      <el-table-column type="index" label="序号" width="51"/>
      <el-table-column prop="order_id" label="订单id" width="51" sortable></el-table-column>
      <el-table-column prop="order_user_id" label="购买者用户id" width="100" sortable></el-table-column>
      <el-table-column prop="order_number" label="订单编号" width="240" sortable/>
      <el-table-column prop="order_price" label="订单总价" width="120" sortable/>
      <el-table-column prop="order_create_time" label="订单产生时间" width="200" sortable/>
      <el-table-column prop="order_update_time" label="订单更新时间" width="200" sortable/>
      <el-table-column label="订单状态" width="120" sortable>
        <template slot-scope="scope">
          <div v-if="scope.row.order_state===0">
            <i class="el-icon-upload2"/>已下单，未支付
          </div>
          <div v-if="scope.row.order_state===1">
            <i class="el-icon-upload2"/>已支付, 待发货
          </div>
          <div v-if="scope.row.order_state===2">
            <i class="el-icon-download"/>已发货，待完成
          </div>
          <div v-if="scope.row.order_state===3">
            <i class="el-icon-s-flag"/>已完成
          </div>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            icon="el-icon-truck"
            v-if="scope.row.order_state===1"
            @click="changeOrderState(scope.row.order_id,2)"
          >
            发货
          </el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-s-flag"
            v-if="scope.row.order_state== 2 || scope.row.order_state === 0"
            @click="changeOrderState(scope.row.order_id,3)"
          >
            结束订单
          </el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-s-flag"
            v-if="scope.row.order_state== 3"
          >
            已完成
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!--目录-->
    <div class="block">
      <!--      <span class="demonstration">直接前往</span>-->
      <el-pagination
        @size-change="limit"
        @current-change="getList"
        :page-size="limit"
        layout="prev, pager, next, jumper"
        :total="total"
        style="padding: 30px 0; text-align: center"
      >
      </el-pagination>
    </div>
  </div>
</template>

<script>
import orderApi from '@/api/order'

export default {
  data() {
    return {
      searchObj: {},
      tableData: [],
      current: 1,
      total: 0,
      limit: 10,
      pickerOptions: {
        shortcuts: [{
          text: '最近一周',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近一个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近三个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      },
      Datevalue: ''
    }
  },
  // 在渲染前运行
  created() {
    this.getList()
  },

  // 各种函数
  methods: {
    // 分页查询
    getList(page = 1) {
      this.current = page
      orderApi.pageSearchForOrder(this.searchObj, this.current, this.limit)
        .then(response => {
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    changeOrderState(id, state) {
      orderApi.updateState(id, state)
        .then(res => {
          console.log(res)
          this.getList(this.current)
        })
        .catch(err => {
          console.log(err)
        })
    },
    handleSortChange(column) {
      this.searchObj.sortColumn = column.prop
      this.searchObj.sortType = column.order
      this.getList(1)
    }
  }
}
</script>

<style scoped>
.bttn {
  margin-left: 10px;
}
</style>

