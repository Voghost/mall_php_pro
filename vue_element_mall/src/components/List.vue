<template>
  <div>
    <el-table
        :data="tabledata"
        style="width: 100%"
        default-expand-all
        ref="multipleTable">
      <el-table-column type="expand">
        <template slot-scope="scope">
          <el-table class="demo-table-expand"
                    :data="scope.row.goods"
                    border
                    style="width: 100%">
            <el-table-column
                label="商品照片"
                width="150">
              <template slot-scope="scope">
                <el-image :src="scope.row.goods_small_logo">
                </el-image>
              </template>
            </el-table-column>
            <el-table-column
                prop="goods_name"
                label="商品名字">
            </el-table-column>
            <el-table-column
                prop="goods_price"
                label="商品单价"
                width="110"
            >
            </el-table-column>
            <el-table-column
                prop="goods_number"
                label="商品数量"
                width="110"
            >
            </el-table-column>
            <el-table-column
                prop="goods_total_price"
                label="商品总价"
                width="110">
            </el-table-column>
            <el-table-column v-if="status" align="center" label="操作" width="150" style="padding:20px">
              <template slot-scope="scope">
                <el-button v-if="status===1" size="small" type="success">催发货</el-button>
                <el-button v-if="status===2" size="small" type="success" @click="getorderlogistic()">物流消息</el-button>
                <el-button v-if="status===3" size="small" type="success" @click="handlecomment(scope.row)">评价
                </el-button>
              </template>
            </el-table-column>
          </el-table>
        </template>
      </el-table-column>
      <el-table-column align="center"
                       label="订单编号"
                       prop="order_number">
      </el-table-column>
      <el-table-column align="center"
                       label="下单时间"
                       :formatter="dateFormat"
      >
      </el-table-column>
      <el-table-column align="center"
                       label="订单总价"
                       prop="total_price">
      </el-table-column>
      <el-table-column align="center" label="操作" width="220">
        <template slot-scope="scope">
          <el-button v-if="status===0" size="small" type="success" @click="Payment(scope.row.order_number)">支付
          </el-button>
          <el-button v-if="status" size="small" type="danger" @click="request_refund(scope.row.order_id)">申请退款/货
          </el-button>
          <el-button v-if="status===2" size="small" type="success" @click="confirm(scope.row.order_id)">确认收货</el-button>
        </template>
      </el-table-column>
    </el-table>
      <GoodsComment :gid="this.comment.goods_id" :orderid="this.comment.order_id" :hand="this.handle" @on-result-change = "changeIsShowDialog" @child-operation="operation"></GoodsComment>


    <el-dialog
        title="支付"
        :visible.sync="dialogVisible"
        width="30%"
        :before-close="handleClose">
      <span>确定支付</span>
      <span slot="footer" class="dialog-footer">
    <el-button @click="handleClose">取 消</el-button>
    <el-button type="primary" @click="handleSave">免密支付</el-button>
  </span>
    </el-dialog>
    <el-dialog
        title="物流消息"
        :visible.sync="visiblehandle"
        width="30%">
      <el-timeline>
        <el-timeline>
          <el-timeline-item
              v-for="(content,index) in logistics_card"
              :key="index"
              :timestamp="content.content"
              color='#0bbd87'
              size="large ">

          </el-timeline-item>
        </el-timeline>
      </el-timeline>
    </el-dialog>
    <el-dialog
        title="退款申请"
        :visible.sync="refundhandle"
        width="40%">
      <el-form :inline="true" :label-position="'top'">
        <el-form-item label="退款理由:">
          <el-input v-model="refund_request" type="el-textarea"></el-input>
        </el-form-item>
        <br>
        <el-button @click="refundhandle=false">取 消</el-button>
        <el-button type="primary" @click="set_request()">确 认</el-button>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>

import GoodsComment from "@/components/GoodsComment";
export default {
  props: ["status", "refund", "refresh"],
  created() {
    this.getOrderList(this.status, this.refund)
  },
  data() {
    return {
      tabledata: [],
      handle: false,
      comment: {},
      dialogVisible: false,
      orderNumber: '',
      visiblehandle: false,
      refundhandle: false,
      logistics_card: [],
      order_id: -1,
      refund_request: ''
    }
  },
  inject: ['reload'],
  components: {GoodsComment},
  methods: {
    getorderlogistic() {
      this.$api.user.getLog(this.order_id).then(res => {
        this.logistics_card = res.data.message;
        this.visiblehandle = true
        console.log(this.logistics_card)
        console.log(this.order_id)
      }).catch(err => {
        console.log(err)
      })
    },
    request_refund(orderId) {
      this.order_id = orderId;
      this.refundhandle = true
      console.log(this.order_id)
    },
    set_request() {

      this.$api.user.refund(this.order_id, this.refund_request)
          .then(res => {
            if (res.data.meta.code === 200) {
              this.refundhandle = false;
              this.$router.push({
                path: 'AboutMe?selectedTag=3'
              })
            }
          })
          .catch(err => {
            console.log(err)
          })
    },
    confirm(id) {
      this.$api.user.finish(id)
      this.reload()
    },
    dateFormat(row) {
      let date = new Date(parseInt(row.create_time) * 1000);
      let Y = date.getFullYear() + '-';
      let M = date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) + '-' : date.getMonth() + 1 + '-';
      let D = date.getDate() < 10 ? '0' + date.getDate() + ' ' : date.getDate() + ' ';
      let h = date.getHours() < 10 ? '0' + date.getHours() + ':' : date.getHours() + ':';
      let m = date.getMinutes() < 10 ? '0' + date.getMinutes() + ':' : date.getMinutes() + ':';
      let s = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
      return Y + M + D + h + m + s;
    },
    handlecomment(data) {
      this.comment = data;
      console.log(this.comment)
      this.handle = true
    },
    operation(type){
      if(type=="confirm"){
        //点击确认要执行的代码
        this.handle=false;
      }else if (type=='cancel'){
        //点击取消要执行的代码
        this.handle=false;
      }
    },
    changeIsShowDialog(val){
      this.handle = val;
    },

    getOrderList(status = '', refund = '') {
      // 待支付
      this.$api.user.getAllOrder(status, refund).then(res => {
        this.tabledata = res.data.message.orders;
        console.log(this.tabledata)
        // console.log(this.tabledata[0].goods[0].goods_id)
      }).catch(err => {
        console.log(err)
      })
    },
    Payment(orderNumber) {
      this.orderNumber = orderNumber
      this.dialogVisible = true
    },
    handleClose() {
      this.dialogVisible = false
      this.$message({
        message: '放弃购买',
        type: 'warning'
      });
      this.reload()
      this.$router.push({
        path: '/AboutMe?selectedTag=3'
      })
    },
    handleSave() {
      this.$api.cart.pay(this.orderNumber)
      this.dialogVisible = false
      this.$message({
        message: '购买成功',
        type: 'success'
      });
      this.reload()
      this.$router.push({
        path: '/AboutMe?selectedTag=3'
      })
    }
  },
}


</script>
