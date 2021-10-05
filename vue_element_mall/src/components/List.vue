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
            <el-table-column v-if="status" align="center" label="操作" width="200" style="padding:20px">
              <template slot-scope="scope">
                <el-button v-if="status===1" size="small" type="success">催发货</el-button>
                <el-button v-if="status===2" size="small" type="success" @click="tracement(scope.row)">物流消息</el-button>
<!--                <el-button v-if="status===3" size="small" type="success" @click="handle=true">评价</el-button>-->
                <el-button v-if="status===3" size="small" type="success" @click="handlecomment(scope.row)">评价</el-button>
                <el-button v-if="status" size="small" type="danger" @click="request_refund(scope.row)">申请退款</el-button>
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
                       prop="create_time">
      </el-table-column>
      <el-table-column align="center"
                       label="下单时间"
                       prop="total_price">
      </el-table-column>
      <el-table-column align="center" label="操作" width="120">
        <template slot-scope="scope">
          <el-button v-if="status===0" size="small" type="success" @click="Payment(scope.row.order_number)">支付
          </el-button>
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
  </div>
</template>

<script>

import GoodsComment from "@/components/GoodsComment";
export default {
  props: ["status", "refund"],
  created() {

    this.getOrderList(this.status, this.refund)

  },
  data() {
    return {
      tabledata: [],
      handle: false,
      comment : {},
      dialogVisible:false,
      orderNumber:'',

      tabsName: 'first', //标签页默认显示
      form: {
        desc: "",
        star: null,
      },
      baseUpdateUrl: 'http://mall.php.test/upload/file',
      fileList: [],
      dialogImageUrl: '',
      dialogPicVisible: false,
      order_id : 99,
      goods_id : 0,
      commentOnsubmit : {},


    }
  },
  inject:['reload'],
  components: {GoodsComment},
  methods: {


    handlecomment(data){
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
        console.log(3,this.tabledata)
        // console.log(this.tabledata[0].goods[0].goods_id)
      }).catch(err => {
        console.log(err)
      })
    },
    toggleSelection(rows) {
      if (rows) {
        rows.forEach(row => {
          this.$refs.multipleTable.toggleRowSelection(row);
        });
      } else {
        this.$refs.multipleTable.clearSelection();
      }
    },
    Payment(orderNumber){
      this.orderNumber=orderNumber
      this.dialogVisible=true
    },
    handleClose() {
      this.dialogVisible=false
      this.$message({
        message: '放弃购买',
        type: 'warning'
      });
      this.reload()
      this.$router.push({
        path:'/AboutMe?selectedTag=3'
      })
    },
    handleSave(){
      this.$api.cart.pay(this.orderNumber)
      this.dialogVisible=false
      this.$message({
        message: '购买成功',
        type: 'success'
      });
      this.reload()
      this.$router.push({
        path:'/AboutMe?selectedTag=3'
      })
    }
  },
}



</script>
