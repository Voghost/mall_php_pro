<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item label="查询语句">
        <el-input v-model="searchObj.goodsName" placeholder="商品名字或评价字段"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="getList()">查询</el-button>
      </el-form-item>
    </el-form>
    <el-table ref="" :data="tableData" border tooltip-effect="dark" style="width: 100%">
      <el-table-column prop="id" label="编号" width="55"></el-table-column>
      <el-table-column prop="goods_id" label="商品编号" width="80"></el-table-column>
      <el-table-column prop="order_id" label="订单编号" width="80"></el-table-column>
      <el-table-column prop="content" label="评价内容" show-overflow-tooltip>
        <template slot-scope="scope">
          <div @click="showComment(scope.row)"> {{ scope.row.content }} </div>
        </template>
      </el-table-column>
      <el-table-column prop="star" label="星级" width="150">
        <template slot-scope="scope">
          <el-rate disabled show-score v-model="scope.row.star"></el-rate>
        </template>
      </el-table-column>
      <el-table-column prop="status" label="状态" width="80">
        <template slot-scope="scope">
          <div v-if="scope.row.status===0">
            <i>可见</i>
          </div>
          <div v-if="scope.row.status===1">
            <i>隐藏</i>
          </div>
        </template>
      </el-table-column>
      <el-table-column label="操作" width="100">
        <template slot-scope="scope">
          <el-button size="mini" type="primary" v-if="scope.row.status===0" @click="updateSataus(scope.row.id)">隐藏</el-button>
          <el-button size="mini" type="success" v-if="scope.row.status===1" @click="updateSataus(scope.row.id)">显示</el-button>
        </template>
      </el-table-column>
    </el-table>
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
<!--     展示商品具体信息  -->
    <el-dialog title="商品详情" :visible.sync="showCommentVisible">
      <div>
        <h2>商品名字:</h2>
        <p>{{ currentGoods.goods_name }}</p>
        <h2>商品主图</h2>
        <img v-bind:src="currentGoods.goods_big_logo" alt="" style="width: 150px; height: auto">
        <h2>商品图片</h2>
        <img v-bind:src="currentGoods.goods_pic_one" alt="" style="margin-left: 20px; width: 150px; height: auto">
        <img v-bind:src="currentGoods.goods_pic_two" alt="" style="margin-left: 20px; width: 150px; height: auto">
        <img v-bind:src="currentGoods.goods_pic_three" alt="" style="margin-left: 20px; width: 150px; height: auto">
        <h2>商品介绍</h2>
        <div v-html="currentGoods.goods_introduce"/>
        <h2>订单价格</h2>
        <p>{{ currentOrder.order_price }}</p>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import commentApi from '@/api/comment'

export default {
  data() {
    return {
      searchObj: {},
      current: 1,
      total: 0,
      limit: 10,
      tableData: [],
      showCommentVisible: false,
      currentComment: {},
      currentOrder: {},
      currentGoods: {}
    }
  },
  mounted() {
    this.getList()
  },

  methods: {
    // 分页查询
    getList(page = 1) {
      this.current = page
      commentApi.pageSearchForComment(this.searchObj, this.current, this.limit)
        .then(response => {
          console.log(response.data.content)
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    showComment(id) {
      // console.log(id)
      commentApi.getGoodsAndOrder(id)
        .then(response => {
          this.currentGoods = response.data.goods
          this.currentOrder = response.data.order
          this.showCommentVisible = true
        })
        .catch(error => {
          console.log(error)
        })
    },
    updateSataus(id) {
      this.comment = {}
      this.comment.id = id
      console.log(this.comment)
      this.$confirm('此操作将修改评论状态，是否继续', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        commentApi.updateCommentStatus(this.comment)
          .then(response => {
            console.log(response)
            this.$message({
              type: 'success',
              message: '修改成功!'
            })
            this.current = 1
            this.getList(1) // 刷新页面
          })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消修改'
        })
      })
    }
  }
}
</script>
