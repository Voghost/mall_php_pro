<template>
  <div style="width: auto;height: 500px;position:relative">
    <div>
      <el-col :span="4" style="height: 200px;width: 200px;">
        <el-col style="padding: 20px 100px 10px;width: 400px;float: left">
          <el-tag class="text">用户名字:</el-tag>
          <el-tag class="text">{{ this.userdata.user_name }}</el-tag>
        </el-col>
        <div class="demo-basic--circle" style="float: left;padding: 40px">
          <div class="block">
            <el-avatar :size="250" :src="circleUrl" style="display: block"></el-avatar>
          </div>
        </div>
      </el-col>

      <el-descriptions :column="1" border class="right_box">
        <el-descriptions-item label="用户性别">
          <el-tag class="text">{{ this.userdata.user_sex }}</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="用户年龄">
          <el-tag class="text">{{ this.userdata.user_age }}</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="用户邮箱">
          <el-tag class="text">{{ this.userdata.user_email }}</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="用户电话">
          <el-tag class="text">{{ this.userdata.user_phone }}</el-tag>
        </el-descriptions-item>
        <el-descriptions-item label="快递地址">
          <el-tag class="text">{{ this.userdata.user_address_default }}</el-tag>
        </el-descriptions-item>
      </el-descriptions>
    </div>
    <el-link href="/AboutMe?selectedTag=4" class="el-button"
             style="font-size: 14px ;line-height: 30px;position:absolute;right: 30px;bottom:30px">修改信息
    </el-link>
  </div>
</template>

<script>
export default {
  name: "UserData",
  data() {
    return {
      userdata: {
        user_email: '123456789@qq.com',
        user_phone: '123456789',
        user_name: '王小虎',
        user_sex: '男',
        user_address_default: 'xxxxxxxxxxx',
        user_age: '18'
      },
      circleUrl: "https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png",
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