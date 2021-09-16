<template>
  <div style="width: auto;height: 500px;">
    <div>
      <el-col :span="4" style="height: 200px;width: 200px;">
        <el-col style="padding: 20px 100px 10px;width: 400px;float: left">
          <el-tag class="text">用户名字:</el-tag>
          <el-tag class="text">张三</el-tag>
        </el-col>
        <div class="demo-basic--circle" style="float: left;padding: 40px">
          <div class="block">
            <el-avatar :size="250" :src="circleUrl" style="display: block"></el-avatar>
          </div>
        </div>
      </el-col>

      <el-descriptions :column="1" border class="right_box">
        <el-descriptions-item label="用户性别">
          <el-tag class="text">男</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="用户年龄">
          <el-tag class="text">18</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="用户邮箱">
          <el-tag class="text">xxxxxx@qq.com</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="用户电话">
          <el-tag class="text">123456798</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="快递地址">
          <el-tag class="text">江苏省苏州市吴中区吴中大道 1188 号</el-tag>
        </el-descriptions-item>
      </el-descriptions>
    </div>
    <div>

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
.right_box {
  width: 700px;
  float: right;
  height: 300px;
  margin-top: 70px;
}

.text {
  font-size: 14px;
}
</style>