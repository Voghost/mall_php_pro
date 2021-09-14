<template>
    <el-container>
      <el-row class="border" style=" width: 100% " v-for="i of 1" :key="i" >
        <el-col class="border" style="height: 100px" :span="6" v-for="j of 4" :key="j">

        </el-col>
      </el-row>
    </el-container>
</template>

<script>
export default {
  name: "404"
}
</script>

<style scoped>
.border {
  border: 1px red solid;
}

</style>
