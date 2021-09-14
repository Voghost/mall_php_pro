<template>
<div style="width: auto;height: auto;">
  <div>

    <el-col :span="6" style="height: 200px;width: 200px;" >
      <el-col style="padding: 10px"><el-tag>用户名字:</el-tag></el-col>
      <div class="demo-basic--circle">
        <div class="block"><el-avatar :size="200" :src="circleUrl" style="display: block"></el-avatar></div>
      </div>
    </el-col>
    <div class="right_box">
      <el-col class="TagBox"><el-tag>用户性别:男/女<br></el-tag></el-col>
      <el-col class="TagBox"><el-tag>快递地址:xx国xx省xx市xx县</el-tag></el-col>
      <el-col class="TagBox"><el-tag>用户年龄:</el-tag></el-col>
      <el-col class="TagBox"><el-tag>用户邮箱:</el-tag></el-col>
      <el-col class="TagBox"><el-tag>用户电话:</el-tag></el-col>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: "userData",
  data() {
    return {
      circleUrl: "https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png",
      squareUrl: "https://cube.elemecdn.com/9/c2/f0ee8a3c7c9638a54940382568c9dpng.png",
      sizeList: ["large", "medium", "small"]
    }
  }
}
</script>

<style scoped>
.right_box{
  width: 600px;
  float: right;
}
.TagBox{
  padding: 10px;
}
</style>