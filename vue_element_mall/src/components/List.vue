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
          <el-button v-if="status===0" size="small" type="success" @click="Payment(scope.row)">支付
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="评论" :visible.sync="handle" width="500px" center>
      <GoodsComment :gid="this.comment.goods_id" :orderid="this.comment.order_id"></GoodsComment>
<!--<GoodsComment :gid="this.tabledata[0].goods[0].goods_id" :orderid="this.tabledata.order_id"></GoodsComment>-->
<!--      <el-form label-width="100px" :model="form" ref="loginFormRef">-->
<!--        <el-form-item label="产品评分:">-->
<!--          <el-rate v-model="form.star" show-text></el-rate>-->
<!--        </el-form-item>-->
<!--        <el-form-item label="评价内容:">-->
<!--          <el-input type="textarea" :rows="3" v-model="form.desc" :maxlength="150" placeholder="请输入内容"-->
<!--                    show-word-limit></el-input>-->
<!--        </el-form-item>-->
<!--        <el-form-item label="上传照片:">-->
<!--          <el-upload :action="baseUpdateUrl"-->
<!--                     list-type="picture-card"-->
<!--                     :file-list="fileList"-->
<!--                     :on-success="handlePicSuccess"-->
<!--                     :on-remove="handleRemove"-->
<!--                     :on-preview="handlePictureCardPreview">-->
<!--            <el-button size="small" type="primary">点击上传</el-button>-->
<!--            <div slot="tip" class="el-upload__tip">只能上传3个jpg/png文件，且不超过10MB</div>-->
<!--          </el-upload>-->
<!--        </el-form-item>-->
<!--        <span slot="footer">-->
<!--      <el-button @click="handle = false">取 消</el-button>-->
<!--      <el-button type="primary" @click="handle = false">确 定</el-button>-->
<!--      </span>-->
<!--      </el-form>-->
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
      // form: {
      //   desc: "",
      //   star: null,
      // },
      // fileList: [],
      // baseUpdateUrl: 'https://jsonplaceholder.typicode.com/posts/',
      tabledata: [],
      handle: false,
      comment : {},
    }
  },
  components: {GoodsComment},
  methods: {
    handlecomment(data){
      this.comment = data;
      console.log(this.comment)
      this.handle = true
    },
    // handleRemove(file, fileList) {
    //   console.log(file, fileList);
    // },
    // handlePictureCardPreview(file) {
    //   this.dialogImageUrl = file.url;
    //   this.dialogVisible = true;
    // },
    // handlePicSuccess(file) {
    //   console.log(file)
    // },
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
    toggleSelection(rows) {
      if (rows) {
        rows.forEach(row => {
          this.$refs.multipleTable.toggleRowSelection(row);
        });
      } else {
        this.$refs.multipleTable.clearSelection();
      }
    },
  },
}


</script>
