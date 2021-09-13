<template>
<div class="main_nav">
  <div class="categories">商品分类
  <div class="categories_dropdown"><Category></Category></div></div>
  <div class="nav_ul">
    <ul>
      <li><a href="#/allgoods/#">商城首页</a></li>
      <li><a href="#/allgoods/#">全部商品</a></li>
  </ul>
  </div>
</div>
</template>

<script>
import Category from "./Category";
export default {
  name: "NavColumns",
  components:{
    Category,
  }
}
</script>
<style scoped>
.main_nav{
  height: 50px;
  width: 100%;
  color: white;
  background: black;
}
.categories{
  height: 50px;
  width: 250px;
  background: deepskyblue;
  color: white;
  text-align: center;
  line-height: 50px;
  margin-left: 60px;
  float: left;
  cursor: pointer;
  position: relative;
  display: inline-block;
}
.categories_dropdown{
  position: absolute;
}
.nav_ul{
  height: 50px;
  width: 500px;
  float: left;
}
.nav_ul ul{
  list-style: none;
  margin-left: 40px;
}
ul li{
  height: 50px;
  width: 100px;
  text-align: center;
  line-height: 50px;
  float: left;
  margin-left:2px;
}
li:hover{
  background: deepskyblue;
}
li a{
  text-decoration: none;
  color: white;
}
</style>