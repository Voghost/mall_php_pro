<template>
<div>
  <el-container  direction="vertical">

    <MallHeader/>

    <!--功能区-->

      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>


    <el-main>
      <GoodsDetails/>
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
  }
}
</script>

<style scoped>

</style>
