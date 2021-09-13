<template>
<div>
  <el-container direction="vertical">
    <MallHeader></MallHeader>
    <!--功能区 -->
      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>
    <NavColumns></NavColumns>
    <div class="background-img">
      <img  src="https://tse1-mm.cn.bing.net/th/id/R-C.b6ee4965e0de2d3f2d4dea6dd2f990ce?rik=YLTrTngbJbRPQg&riu=http%3a%2f%2fhzyly.com%2fupload%2f201908%2f26%2f201908261930008705.jpg&ehk=lAzMBzQFHc8trdBO2lILa1LYDOAHagoX0HiBZTXbYQM%3d&risl=&pid=ImgRaw&r=0">
    </div>
    <div class="main_content" >
      <div class="content_search">

      </div>
      <GoodsCard></GoodsCard>
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
    MallFooter,
    GoodsCard,
    MallHeader,
    SearchHeader,
    NavColumns,
  }
}
</script>

<style scoped>
.background-img img{
  height: 504px;
  width: 100%;
  
}
.main_content{
  height: 600px;
  width: 100%;
  border: 1px red solid;
}
.content_search{
  height: 80px;
  width: 100%;
  border: 1px blue solid;
}
</style>
