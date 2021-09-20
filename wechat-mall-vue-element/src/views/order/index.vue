<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item label="订单编号">
        <el-input v-model="searchObj.order_number" placeholder="订单编号"/>
      </el-form-item>
      <el-form-item label="订单状态">
        <el-select v-model="searchObj.order_state" clearable placeholder="请选择">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
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
          <div v-if="scope.row.order_state===0 && scope.row.order_refund === 0">
            <i class="el-icon-upload2"/>已下单，未支付
          </div>
          <div v-if="scope.row.order_state===1 && scope.row.order_refund === 0">
            <i class="el-icon-upload2"/>已支付, 待发货
          </div>
          <div v-if="scope.row.order_state===2 && scope.row.order_refund === 0" @click="showLogVisible = true, currentLog=scope.row.loglist">
            {{ scope.row.latest }}
          </div>
          <div v-if="scope.row.order_state===3 && scope.row.order_refund === 0" @click="showLogVisible = true, currentLog=scope.row.loglist">
            <i class="el-icon-s-flag"/>已完成
          </div>
          <div v-if="scope.row.order_refund===1">
            <i class="el-icon-s-flag"/>申请退款，待审核
          </div>
          <div v-if="scope.row.order_refund===2">
            <i class="el-icon-s-flag"/>已退款
          </div>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            icon="el-icon-truck"
            v-if="scope.row.order_state===1 && scope.row.order_refund === 0"
            @click="newlog(scope.row.order_id)"
          >
            发货
          </el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-s-flag"
            v-if="scope.row.order_state === 0 && scope.row.order_refund === 0"
          >
            等待用户确认
          </el-button>
          <el-button
            type="success"
            size="mini"
            icon="el-icon-map-location"
            v-if="scope.row.order_state === 2 && scope.row.order_refund === 0"
            @click="newlog(scope.row.order_id)"
          >
            修改物流信息
          </el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-s-flag"
            v-if="scope.row.order_state === 3 && scope.row.order_refund === 0"
          >
            已完成订单
          </el-button>
          <el-button
            type="success"
            size="mini"
            icon="el-icon-s-flag"
            v-if="scope.row.order_refund === 1"
            @click="audit(scope.row)"
          >
            审核
          </el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-s-flag"
            v-if="scope.row.order_refund === 2"
          >
            已完成退款
          </el-button>
          <el-dialog title="物流信息" :visible.sync="showLog">
            <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
              <el-form-item label="添加物流信息">
                <el-input v-model="currentLog.logis" placeholder="请输入当前物流状态" required style="width: 300px"></el-input>
              </el-form-item>
              <br>
              <el-form-item>
                <el-button type="primary" @click="submitLog">提交</el-button>
              </el-form-item>
            </el-form>
          </el-dialog>
          <el-dialog title="退款信息" :visible.sync="showRef">
            <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
              <el-form-item label="退款理由:">
                {{ currentRef.order_refund_content}}
              </el-form-item>
              <br>
              <el-form-item>
                <el-button type="primary" @click="submitRef(currentRef.order_id, 2)">允许</el-button>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" @click="submitRef(currentRef.order_id,0)">拒绝</el-button>
              </el-form-item>
            </el-form>
          </el-dialog>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="物流详情" :visible.sync="showLogVisible">
      <div class="block">
        <div class="radio">
          排序：
          <el-radio-group v-model="reverse">
            <el-radio :label="true">倒序</el-radio>
            <el-radio :label="false">正序</el-radio>
          </el-radio-group>
          <br>
          <br>
          <el-timeline :reverse="reverse">
            <el-timeline-item
              v-for="(activity, index) in currentLog"
              :key="index"
              :timestamp="activity.time">
              {{activity.content}}
            </el-timeline-item>
          </el-timeline>
        </div>
      </div>
    </el-dialog>
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
      reverse: true,
      searchObj: {},
      tableData: [],
      current: 1,
      total: 0,
      showLogVisible: false,
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
      Datevalue: '',
      showLog: false,
      currentLog: {},
      showRef: false,
      currentRef: {},
      options: [{
        value: '1',
        label: '待支付'
      }, {
        value: '2',
        label: '待发货'
      }, {
        value: '3',
        label: '待确认'
      }, {
        value: '4',
        label: '待审批'
      }, {
        value: '5',
        label: '已退款'
      }, {
        value: '6',
        label: '已完成'
      }],
      value: ''
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
    newlog(id) {
      this.showLog = true
      this.currentLog = {}
      this.currentLog.id = id
      this.currentLog.state = 2
      console.log(this.currentLog.id)
    },
    submitLog() {
      this.changeOrderState(this.currentLog.id, this.currentLog.state, this.currentLog)
      this.showLog = false
    },
    changeOrderState(id, state, content) {
      orderApi.updateState(id, state, content)
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
    },
    audit(data) {
      this.showRef = true
      this.currentRef = data
    },
    submitRef(id, state) {
      this.changeOrderRefund(id, state)
      this.showRef = false
    },
    changeOrderRefund(id, state) {
      orderApi.updateState(id, state)
        .then(res => {
          console.log(res)
          this.getList(this.current)
        })
        .catch(err => {
          console.log(err)
        })
    }
  }
}
</script>

<style scoped>
.bttn {
  margin-left: 10px;
}
</style>

