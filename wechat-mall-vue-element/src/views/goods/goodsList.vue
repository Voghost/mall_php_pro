<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item label="商品名字">
        <el-input v-model="searchObj.goodsName" placeholder="商品名字"/>
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
      :default-sort="{prop: 'goods_id', order: 'descending'}"
    >
      <el-table-column type="index" label="序号" width="51"/>
      <el-table-column prop="goods_id" label="商品id" width="65" sortable>
        <template slot-scope="scope">
          G{{ scope.row.goods_id }}
        </template>
      </el-table-column>
      <el-table-column prop="goods_name" label="商品名字" width="250" sortable>
        <template slot-scope="scope">
          <div @click="showGoodsVisible = true, currentGoods=scope.row">{{ scope.row.goods_name }}</div>
        </template>
      </el-table-column>
      <!--      <el-table-column prop="goodsIntroduce" label="商品介绍" width="200"/>-->
      <el-table-column prop="goods_price" label="商品价格" width="140" sortable/>
      <el-table-column prop="goods_weight" label="商品重量(kg)" width="100" sortable/>
      <el-table-column prop="goods_number" label="商品存量" width="100" sortable/>
      <el-table-column prop="goods_add_time" label="商品添加日期" width="160" sortable/>
      <el-table-column prop="goods_upd_time" label="商品修改日期" width="160" sortable/>
      <el-table-column label="商品状态" width="120">
        <template slot-scope="scope">
          <div v-if="scope.row.goods_state===2">
            <i class="el-icon-upload2"/>上架
          </div>
          <div v-if="scope.row.goods_state===1">
            <i class="el-icon-download"/>下架
          </div>
          <div v-if="scope.row.goods_state===0">
            <i class="el-icon-s-flag"/>已删除
          </div>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button type="danger" size="mini" icon="el-icon-delete" @click="removeById(scope.row.goods_id)">
            删除
          </el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-download"
            v-if="scope.row.goods_state===2"
            @click="upOrDownGoods(scope.row.goods_id, 1)"
          >
            下架
          </el-button>
          <el-button
            type="primary"
            size="mini"
            icon="el-icon-upload2"
            v-if="scope.row.goods_state===1"
            @click="upOrDownGoods(scope.row.goods_id, 2)"
          >
            上架
          </el-button>
          <br>
          <br>
          <el-button type="primary" icon="el-icon-edit" @click="edit(scope.row)" size="mini">
            编辑
          </el-button>
          <el-button type="success" icon="el-icon-goods" @click="test(scope.row)" size="mini">
            查看评价
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
    <!-- 展示商品具体信息  -->
    <el-dialog title="商品详情" :visible.sync="showGoodsVisible">
      <div>
        <h2>商品名字:</h2>
        <p>{{ currentGoods.goods_name }}</p>
        <h2>商品主图</h2>
        <img v-bind:src="currentGoods.goods_big_logo" alt="" style="width: 150px; height: auto">
        <h2>商品图片</h2>
        <el-carousel style="width: 70%" height="400">
          <el-carousel-item v-for="item in currentGoods.pics" :key="item.id">
            <el-image style="width: 100%" :src="item.url" fit="cover"></el-image>
          </el-carousel-item>
        </el-carousel>
        <h2>商品介绍</h2>
        <div v-html="currentGoods.goods_introduce"/>
      </div>
    </el-dialog>
    <!-- 展示商品具体评价  -->
    <el-dialog title="评论详情" :visible.sync="showCommentWithOrder">
      <div v-if="currentTemp.length === 0">
        <h2>暂无评论</h2>
      </div>
      <div v-else>
        <div v-for="(item,index) in currentTemp" :key="index" class="commentblock">
          <p> {{ item.user_name }} 购买了此商品</p>
          <p class="commentbox1">购买类型:{{ item.order.order_price }}</p>
          <p class="commentbox2">
            <el-rate disabled show-score v-model="item.star"></el-rate>
          </p>
          <h4 class="commentbox3">该用户评价:{{ item.content }}</h4>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import goodsApi from '@/api/goods'

export default {
  data() {
    return {
      searchObj: {},
      tableData: [],
      current: 1,
      total: 0,
      limit: 10,
      showGoodsVisible: false,
      showGoodsUserVisible: false,
      dialogTableVisible: false,
      showCommentWithOrder: false,
      currentGoods: {},
      currentComment: {},
      currentTemp: {},
      currentTemp1: {},
      goods: {},
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
      goodsApi.pageSearchForGoods(this.searchObj, this.current, this.limit)
        .then(response => {
          console.log(this.searchObj)
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    upOrDownGoods(id, state) {
      this.goods = {} // 置为空
      this.goods.goodsId = id
      this.goods.goodsState = state
      goodsApi.updateGoods(this.goods)
        .then(response => {
          console.log(response)
          this.getList(this.current)
        })
        .catch(error => {
          console.log(error)
        })
    },

    removeById(id) {
      this.goods = {} // 置为空
      this.goods.goodsId = id
      this.goods.goodsState = 0
      console.log(this.goods)
      this.$confirm('此操作将删除商品置信息, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        // 调用接口

        goodsApi.deleteGoods(this.goods)
          .then(response => {
            console.log(response)
            this.$message({
              type: 'success',
              message: '删除成功!'
            })
            this.current = 1
            this.getList(1) // 刷新页面
          })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        })
      })
    },
    edit(pushGoods) {
      this.$router.push({
        path: '/goodsManager/goodsEditor',
        query: {
          goods: pushGoods
        }
      }) // 带参跳转
    },
    test(num) {
      // alert('hello' + num)
      goodsApi.getCommentWithOrder(num)
        .then(response => {
          this.currentTemp = response.data
          this.currentTemp1 = response.data.order
          this.showCommentWithOrder = true
        })
        .catch(error => {
          console.log(error)
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
.commentblock {
  padding: 25px;
  border-radius: 4px;
  margin-top: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)
}
.commentbox1 {
  margin-top: 10px;
  float: left;
}
.commentbox2 {
  margin-top: 10px;
  margin-left: 20px;
  float: left;
}
.commentbox3 {
  margin-top: 50px;
  clear: both;
}
.bttn {
  margin-left: 10px;
}
</style>

