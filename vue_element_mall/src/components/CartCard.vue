<template>
  <el-container>
    <div class="cart_item">
      <div class="cart_nav">
        <el-row>
          <el-col :span="24">
            <input type="checkbox" :checked="allCheck" @click="allChecked()">全选
            <span style="margin-left: 205px;">商品信息</span>
            <span style="margin-left: 465px;">单价</span>
            <span style="margin-left: 145px;">数量</span>
            <span style="margin-left: 85px;">金额</span>
            <span style="margin-left: 123px;">操作</span>
          </el-col>
        </el-row>
      </div>
      <el-row>
        <el-col :span="24" v-for="(i,index) in items" :key="i.name">
          <el-card :body-style="{padding:'0px'}"  shadow="none">
            <div class="goods_check">
              <input type="checkbox"  :value="index" @click=checked() v-model="arr">
            </div>
            <div class="goods_img">
<!--              <img src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image">-->
              <el-popover placement="right-start" title="" trigger="hover">
                <img  src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" style="width:300px;height: 300px">
                  <img slot="reference" src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image">
              </el-popover>
            </div>
            <div class="goods_title">
              <span><a href="#" style="text-decoration: none;color: black" target="_blank">{{i.name}}</a></span>
            </div>
            <div class="goods_introduce">

            </div>
            <div class="goods_price">
              <p>￥{{ i.price }}</p>
            </div>
            <div class="goods_num">
              <el-input-number v-model="i.number" @change="handleChange(index)" :min="1" :max="999" label="描述文字"></el-input-number>
            </div>
            <div class="goods_total">
              <p>￥{{ i.total }}</p>
            </div>
            <div class="operation">
              <p><a href="#" style="text-decoration: none;color: black; margin: 0 auto" @click="dialogVisible = true">删除</a></p>
            </div>
          </el-card>
        </el-col>
      </el-row>
      <div class="cart_footer" >
        <el-row>
          <el-col :span="24">
            <span style="width: 120px;margin-left: 1000px;margin-top:10px;display: block;float:left">已选商品<span style="color: red">{{this.arr.length}}</span>件</span>
            <span style="width: 100px;margin-left: 20px;margin-top:10px;display: block;float: left">合计:<span style="color: red;">{{this.totalPrice}}</span></span>
            <el-button type="danger" style="margin-right: 60px;float: right">结算</el-button>
<!--            结算按钮-->
          </el-col>
        </el-row>
      </div>
    </div>
    <el-dialog
        title="删除宝贝"
        :visible.sync="dialogVisible"
        width="30%">
      <span>哥哥，真的要删除宝贝吗</span>
      <span slot="footer" class="dialog-footer">
    <el-button @click="dialogVisible = false">取 消</el-button>
    <el-button type="primary" @click="handleDel()">确 定</el-button>
  </span>
    </el-dialog>
  </el-container>
</template>

<script>

export default {
  name: "CartCard",

  data(){
    return{
      num:1,
      allCheck:false,
      totalPrice:0,
      items:[{"img_path":"1","name":"鼎中鼎澳门豆捞1","price":1.00,"number":1.00,"total":1,},
        {"img_path":"12","name":"鼎中鼎澳门豆捞2","price":2.00,"number":1.00,"total":2,},
        {"img_path":"12","name":"鼎中鼎澳门豆捞3","price":3.00,"number":1.00,"total":3,},
        {"img_path":"12","name":"鼎中鼎澳门豆捞4","price":3.00,"number":1.00,"total":3,},
        {"img_path":"12","name":"鼎中鼎澳门豆捞5","price":3.00,"number":1.00,"total":3,}],
      arr: [],
      dialogVisible: false,
    };
  },
  methods: {
    //修改数量
    handleChange(index) {
      this.ItemTotalMoney(index)
      this.TotalMoney()
    },
    //删除
    handleDel() {
      console.log("点击了删除");
    this.dialogVisible=false;
    },
    //单选
    checked() {
      if(this.items.length>this.arr.length)
      {
        this.allCheck=false
      }
      if(this.items.length===this.arr.length)
      {
        this.allCheck=true
      }
      this.TotalMoney()
    },
    //全选
    allChecked() {
      //不为空
      if (event.target.checked) {
        this.arr = [];
        for (let index = 0; index < this.items.length; index++) {
          this.arr.push(index)
        }
        this.allCheck=true
      } else {
        this.arr = [];
        this.allCheck=false
      }
      this.TotalMoney()
    },
    //单个商品总价
    ItemTotalMoney(index){
      let price=0;
      price=this.items[index].price*this.items[index].number
      this.items[index].total=price
    },
    //全部商品总价
    TotalMoney() {
      let allprice = 0
      for (let index = 0; index < this.arr.length; index++) {
        //allprice+=this.items[this.arr[index]].total * this.items[this.arr[index]].number
        allprice+=this.items[this.arr[index]].total
      }
      this.totalPrice = allprice

    },
  },
  created() {
    this.TotalMoney()
  },
  watch:{
    'arr.length': {
      handler(newValue, oldValue) {
        if (newValue !== oldValue) {
          this.TotalMoney()
          this.checked()
        }
      }
    }
  }
}
</script>

<style scoped>
.cart_nav{
  width: 1380px;
  height: 30px;
  margin: 0 auto;
}
.cart_nav input{
  margin-left: 16px;
  margin-top:11px;
}
.cart_item{
  width: 1380px;
  /*border: 1px black solid;*/
}
.el-card{
  height: 160px;
  width: 1380px;
  margin: 15px auto;
}
.goods_check {
  width: 40px;
  margin-top:60px;
  margin-right: -40px;
  float: left;
}
.goods_check input{
  margin-left: 10px;
}
.goods_img{
  height: 120px;
  width: 200px;
  margin-left: 50px;
  margin-top: 20px;
  float: left;
}
.image {
  height: 120px;
  width: 200px;
  display: block;
}
.goods_title{
  height: 120px;
  width: 280px;

  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_introduce{
  height: 120px;
  width: 230px;

  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_price{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_price p{

  display: block;

  font-size: 20px;
  font-family: "Microsoft YaHei";
}
.goods_price{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_num{
  height: 120px;
  width: 125px;
  float: left;
  margin-top: 20px;
  margin-left: 30px;
}
.el-input-number{
  width: 120px;
  size: auto;

}
.goods_total{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 40px;
}
.goods_total p{

  display: block;

  font-size: 20px;
  font-family: "Microsoft YaHei";
  color: red;
}
.operation{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 60px;
}
.cart_footer{
  height: 50px;


}

</style>