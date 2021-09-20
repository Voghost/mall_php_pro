<template>
<div>
  <el-container  direction="vertical">

    <MallHeader/>

    <!--功能区-->

      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>


    <el-main>
      <GoodsDetails :goods_id="goods_id" />
    </el-main>

    <MallFooter/>

  </el-container>
</div>
</template>

<script>
import GoodsDetails from "@/components/GoodsDetails";
import MallFooter from "@/components/MallFooter";
import MallHeader from "@/components/MallHeader";
import SearchHeader from "@/components/SearchHeader";
export default {
  name: "GoodsDetail",
  components : {
    GoodsDetails,
    MallFooter,
    MallHeader,
    SearchHeader
  },
  data()
  {
    return{
      goods_id:0,
    }
  },
 created() {
    this.goods_id=this.$route.query.goods_id;
    if(this.goods_id===undefined)
    {
      this.$router.push({
        path: '/',

      }) // 带参跳转
    }
  }

}
</script>

<style scoped>

</style>
