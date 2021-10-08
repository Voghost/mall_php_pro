<template>
  <div>
    <el-container direction="vertical">
      <MallHeader></MallHeader>
      <!--功能区 -->
      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>
      <NavColumns></NavColumns>
      <div class="background-img">
        <!--      <img src="https://tse1-mm.cn.bing.net/th/id/R-C.45018e3466aa07dbecabc2c67f777b1a?rik=oTUSfBN5adTUVg&riu=http%3a%2f%2fnewssrc.onlinedown.net%2fd%2ffile%2f20160814%2f04c43ee83f0fb75c03a0be183d3358e6.jpg&ehk=nie1KWg9fnDUHtey92J2ewLkEv%2bqGQVt2eDB1QO83e0%3d&risl=&pid=ImgRaw&r=0">-->
        <img :src="imgUrl">
      </div>
      <div class="main_content">
        <div class="main_goods">
          <el-row v-for="i of row_index"
                  :key="i" style="min-width: 1000px">
            <el-col v-for="j of col_index"
                    :key="j" :span="6" style="min-width: 240px" class="goodsLoading">
              <GoodsCard class="goodsLoading" :goods="goods[((i-1)*4)+(j-1)]"></GoodsCard>
            </el-col>
          </el-row>
        </div>
        <div class="pagination">
          <el-row>
            <el-col :span="24">
              <el-pagination
                  background
                  @current-change="changePage"
                  :page-size="size"
                  layout="prev, pager, next"
                  :total="totalNum"
                  style="padding-left: 100px;">
              </el-pagination>
            </el-col>
          </el-row>
        </div>
      </div>
      <!-- footer   -->
      <MallFooter></MallFooter>
    </el-container>
  </div>
</template>

<script>
import MallHeader from "@/components/MallHeader";
import SearchHeader from "@/components/SearchHeader";
import NavColumns from "../components/NavColumns";
import GoodsCard from "../components/GoodsCard";
import MallFooter from "../components/MallFooter";

export default {
  name: "AllGoods",
  components: {
    GoodsCard,
    MallHeader,
    SearchHeader,
    NavColumns,
    MallFooter,
  },
  data() {
    return {
      goods: [],
      current: 1,
      size: 24,
      row_index: 0,
      col_index: 4,
      totalNum: 0,
      searchObj: {},
      imgUrl: "https://tse1-mm.cn.bing.net/th/id/R-C.45018e3466aa07dbecabc2c67f777b1a?rik=oTUSfBN5adTUVg&riu=http%3a%2f%2fnewssrc.onlinedown.net%2fd%2ffile%2f20160814%2f04c43ee83f0fb75c03a0be183d3358e6.jpg&ehk=nie1KWg9fnDUHtey92J2ewLkEv%2bqGQVt2eDB1QO83e0%3d&risl=&pid=ImgRaw&r=0"
    }
  },
  props: [
    'cat_id',
    'cat_icon'
  ],
  methods: {
    getGoodsInfo(page = 1, query = null) {
      console.log("search1111222", query)
      query.sortColumn = 'goods_id'; // 逆序
      query.sortType = 'desc'; // 逆序
      this.current = page
      this.$api.goods.pageSearch(this.current, this.size, query)
          .then(res => {
            this.goods = res.data.message.content;
            this.totalNum = res.data.message.total;
            this.row_index = parseInt(this.goods.length / this.col_index)
            if (this.goods.length % this.col_index) {
              this.row_index++;
            }
            console.log(this.searchObj['goodsCatThreeId'])
          })
          .catch(err => {
            console.log(err)
          })
    },
    changePage(page) {
      this.getGoodsInfo(page, this.searchObj)
      document.documentElement.scrollTop = 680;
    }
  },
  mounted() {
    if (this.$route.query.cat_id !== undefined) {
      this.searchObj.goodsCatThreeId = this.$route.query.cat_id
    }
    //console.log(this.$route.query.cat_icon)
    if (this.$route.query.cat_icon !== undefined) {
      this.imgUrl = this.$route.query.cat_icon
    }
    if (this.$route.query.name !== undefined) {
      this.searchObj.goodsName = this.$route.query.name
    }
    this.getGoodsInfo(1, this.searchObj)
    console.log("obj: ", this.searchObj)

  },
  watch: {
    $route() {
      if (this.searchObj.goodsCatThreeId !== undefined) {
        this.searchObj.goodsCatThreeId = this.$route.query.cat_id
      }
      if (this.$route.query.name !== undefined) {
        this.searchObj.goodsName = this.$route.query.name
      }

      if (this.$route.query.cat_icon) {
        this.imgUrl = this.$route.query.cat_icon
      } else {
        this.imgUrl = "https://tse1-mm.cn.bing.net/th/id/R-C.45018e3466aa07dbecabc2c67f777b1a?rik=oTUSfBN5adTUVg&riu=http%3a%2f%2fnewssrc.onlinedown.net%2fd%2ffile%2f20160814%2f04c43ee83f0fb75c03a0be183d3358e6.jpg&ehk=nie1KWg9fnDUHtey92J2ewLkEv%2bqGQVt2eDB1QO83e0%3d&risl=&pid=ImgRaw&r=0"
      }
      this.getGoodsInfo(1, this.searchObj)
      document.documentElement.scrollTop = 680;
    }
  }
}
</script>

<style scoped>
.background-img img {
  height: 700px;
  width: 100%;

}

.main_content {

  height: auto;
  width: auto;
  margin: 0 auto;
}

.main_content:before {
  content: '';
  clear: both;
  display: block;
}

.main_goods {
  width: auto;
  margin: 0 auto;
}

.pagination {
  height: 50px;
  width: 40%;
  margin: 50px auto;


}
</style>
