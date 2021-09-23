<template>
  <el-table :data="list" style="width: 100%;padding-top: 15px;">
    <el-table-column label="Order_No" min-width="200">
      <template slot-scope="scope">
        {{ scope.row.order_number}}
      </template>
    </el-table-column>
    <el-table-column label="Price" width="195" align="center">
      <template slot-scope="scope">
        ¥{{ scope.row.order_price}}
      </template>
    </el-table-column>
    <el-table-column label="Status" width="100" align="center">
      <template slot-scope="{row}">
        <el-tag type="danger" v-if="row.order_state === 0 && row.order_refund === 0">
          未支付
        </el-tag>
        <el-tag type="info" v-if="row.order_state === 1 && row.order_refund === 0">
          待发货
        </el-tag>
        <el-tag v-if="row.order_state === 2 && row.order_refund === 0">
          待收货
        </el-tag>
        <el-tag type="success" v-if="row.order_state === 3 && row.order_refund === 0">
          已完成
        </el-tag>
        <el-tag type="warning" v-if="row.order_refund === 1">
          退款中
        </el-tag>
        <el-tag type="danger" v-if="row.order_refund === 2">
          已退款
        </el-tag>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
import echartApi from '@/api/echart'

export default {
  filters: {
    statusFilter(status) {
      const statusMap = {
        success: 'success',
        pending: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      list: null
    }
  },
  created() {
    this.initTable()
  },
  methods: {
    initTable() {
      setInterval(this.fetchData, 20000)
      this.fetchData()
    },
    fetchData() {
      echartApi.getTenOrder()
        .then(response => {
          console.log(response)
          this.list = response.data
      })
    }
  }
}
</script>
