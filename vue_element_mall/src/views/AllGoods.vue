<template>
<div>
  <el-container direction="vertical">
    <MallHeader></MallHeader>
    <!--功能区 -->
      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>
    <NavColumns></NavColumns>
    <div class="background-img">
      <img  src="">
    </div>
    <div class="main_content">
      <el-row v-for="i of row_index"
      :key="i" style="min-width: 1000px" >
        <el-col v-for="j of col_index"
        :key="j" :span="6" style="min-width: 240px">
          <GoodsCard :goods="goods[((i-1)*4)+(j-1)]"></GoodsCard>
        </el-col>
      </el-row>
      <div class="pagination">
        <el-row>
          <el-col :span="24">
            <el-pagination
                background
                @current-change="changePage"
                :page-size="size"
                layout="prev, pager, next"
                :total="totalNum"
            style="padding-left: 80px">
            </el-pagination>
          </el-col>
        </el-row>
      </div>
    </div>
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
  components:{
    GoodsCard,
    MallHeader,
    SearchHeader,
    NavColumns,
    MallFooter,
  },
  data(){
    return{
      goods:[],
      current:1,
      size:24,
      row_index:0,
      col_index:4,
      totalNum:0

    }
  },
  methods:{
    getGoodsInfo(page=1){
      this.current=page
      this.$api.goods.pageSearch(this.current,this.size)
          .then(res => {
            this.goods=res.data.message.content;
            this.totalNum=res.data.message.total;
            this.row_index=parseInt(this.goods.length/this.col_index)
            if(this.goods.length%this.col_index){
              this.row_index++;
            }

          })
          .catch(err => {
            console.log(err)
          })
    },
    changePage(page){
      this.getGoodsInfo(page)
      document.documentElement.scrollTop=680;
    }
  },
  mounted(){
    this.getGoodsInfo()
  }
}
</script>

<style scoped>
.background-img img{
  height: 504px;
  width: 100%;
  
}
.main_content{
  height: 2100px;
  width: 80%;
  margin: 0 auto;

}
.pagination{
  height: 50px;
  width: 50%;
  margin: 50px auto;


}
</style>
