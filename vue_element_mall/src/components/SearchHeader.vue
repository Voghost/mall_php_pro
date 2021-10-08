<template>
    <el-row justify="center" type="flex" style="width: 100%">
      <el-col :span="6">
        <div class="box">
          DGUT 小卖部
        </div>
      </el-col>
      <el-col :span="12">
        <div class="box">
          <GoodsSearch></GoodsSearch>
        </div>
      </el-col>
    </el-row>
</template>

<script>
import GoodsSearch from "./GoodsSearch";
export default {
  name: "SearchHeader",
  components: {
    GoodsSearch
  }
}
</script>

<style scoped>
.box{
  height: 150px;
  width: 100%;
  text-align: center;
  line-height: 150px;
  font-size: 40px;
}

.border{
}

</style>
