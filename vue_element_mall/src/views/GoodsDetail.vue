<template>
<div>
  <el-container>

    <MallHeader/>

    <!--功能区-->
    <el-header class="" style="height: 180px; width: 100%">
      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>
    </el-header>

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
