<template>
  <el-row justify="center" type="flex" style="width: 100%;padding:40px 0 0 0">
    <el-col :span="6" >
      <el-link href="#" class="link" style="font-size: 14px ;line-height: 30px">我的首页</el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#" class="link" style="font-size: 14px">账号设置</el-link>
    </el-col>
    <el-col :span="10" style="height: 50px">
      <div class="box">
        <GoodsSearch></GoodsSearch>
      </div>
    </el-col>
  </el-row>
</template>

<script>
import GoodsSearch from "./GoodsSearch";
export default {
  name: "ThingTittle",
  components: {
    GoodsSearch
  }
}
</script>

<style scoped>


</style>