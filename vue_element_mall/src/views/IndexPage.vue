<template>
  <div>
    <el-backtop target=".app" :visibility-height="400"></el-backtop>
    <el-container>

      <MallHeader/>
      <!--功能区-->
      <el-header class="" style="height: 180px; width: 100%">
        <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>
      </el-header>

      <el-main class="">
        <!--   分类和主页大图   -->
        <el-container style="margin-top: 10px;" class="">
          <el-row type="flex" justify="center" style="width: 100%">
            <el-col :span="3" :offset="1">
              <Category style="float: right; min-width: 200px;"></Category>
            </el-col>
            <el-col :span="12" class="" style="margin-left: 40px;">
              <el-carousel height="500px" style="min-width: 600px; width: 800px" indicator-position="outside">
                <el-carousel-item v-for="item in pics" :key="item">
                  <a href="#">
                    <el-image :src="item.image_src" style="width: 100%; height: 100%" :fit="'cover'">
                    </el-image>
                  </a>
                </el-carousel-item>
              </el-carousel>
            </el-col>
          </el-row>
        </el-container>
      </el-main>

      <el-main class="">
        <FloorItem v-for=" item, index in floors"
                   :key="index"
                   :src="item.floor_title.image_src"
                   :num="index+1"
                   :title="item.floor_title.name"
        />
      </el-main>

      <MallFooter></MallFooter>
    </el-container>
  </div>
</template>

<script>
import MallHeader from "@/components/MallHeader";
import SearchHeader from "@/components/SearchHeader";
import Category from "@/components/Category";
// import FloorItem from "@/components/FloorItem";
import MallFooter from "@/components/MallFooter";
import FloorItem from "@/components/FloorItem";

export default {
  name: 'IndexPage',
  data() {
    return {
      pics: [],
      categories: {},
      floors: {},
      floorNum: 1,
    }
  },
  components: {
    FloorItem,
    MallHeader,
    SearchHeader,
    Category,
    // FloorItem,
    MallFooter
  },
  methods: {
    getAllFloor() {
      this.$api.main_page.floor()
          .then(res => {
            this.floors = res.data.message
            console.log(this.floors)
          })
    },
    getSwiperPics() {
      this.$api.main_page.getPics()
          .then(res => {
            this.pics = res.data.message;
          })
          .catch(err => {
            console.log(err)
          })
    }
  },
  mounted() {
    this.getAllFloor();
    this.getSwiperPics();
  }
}
</script>
<style>

body {
  min-width: 900px;
}

* {
  margin: 0;
  padding: 0;
}

.main {
  height: 500px;
  width: 800px;
  /*border: 2px solid black;*/
}

.border {
  border: 2px solid red;
}


.title {
  width: 120px;
  margin: 10px auto;
  font-size: 20px;
  float: right;
}

.content {
  clear: both;
  list-style: none;
  width: 120px;
  margin: 10px auto;
  font-size: 14px;
  float: right;
}

.content > li {
  margin-top: 4px;
}

</style>
