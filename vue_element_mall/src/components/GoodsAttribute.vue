<template>
  <div>
    <div class="popupSub" >已选规格：{{showSelectSpec}}</div>
    <div class="subItem" v-for="(item,index) in subItemList" :key="index">
      <div class="itemTitle">{{item.itemTitle}}</div>
      <div class="itemContent">
        <ul>
          <li
              v-for="(res,resIndex) in item.itemContent"
              :key="res"
              @click="selectItem(res,index,$event,resIndex)"
              :class="subIndex[index] == resIndex?'selectActive':'itemLi'"
          >{{res}}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "GoodsAttribute",
  data() {
    return {
      showSelectSpec: "",
      subItemList: [
        {
          itemTitle: "味道",
          itemContent: ["原味", "猕猴桃味", "橙子味", "苹果味", "菠萝味"]
        },
        {
          itemTitle: "容量",
          itemContent: ["300ML", "400ML", "500ML", "1000ML"]
        }
      ],
      selectArr: [], // 存放被选中的值
      subIndex: [] // 是否选中 因为不确定是多规格还是但规格，所以这里定义数组来判断
    }
  },
  methods: {
    selectItem(res, index, enevt, resIndex) {
      let t = this;
      if (t.selectArr[index] !== res) {
        t.selectArr[index] = res;
        t.subIndex[index] = resIndex;
      } else {
        t.selectArr[index] = "";
        t.subIndex[index] = -1; // 去掉选中的颜色
      }
      t.checkItem();
    },
    checkItem: function() {
      var self = this;
      var option = self.subItemList;
      var result = []; // 定义数组存储被选中的值
      console.log(JSON.parse(JSON.stringify(self.selectArr)));
      for (let i in option) {
        result[i] = self.selectArr[i] ? self.selectArr[i] : "";
      }
      for (let i in option) {
        var last = result[i]; // 把选中的值存放到字符串last去
        for (let k in option[i].item) {
          result[i] = option[i].item[k].name; // 赋值，存在直接覆盖，不存在往里面添加name值
          console.log("这里:", JSON.parse(JSON.stringify(result)));
        }
        result[i] = last; // 还原，目的是记录点下去那个值，避免下一次执行循环时避免被覆盖
      }
      self.$forceUpdate(); // 重绘
      self.showSelectSpec = self.selectArr.join("、");
      console.log(self.showSelectSpec);
    }
  }
}
</script>

<style scoped>
.popupSub {
  color: #aaaaaa;
  font-size: 0.8em;
  margin-top: 5px;
  letter-spacing: 2px;
}
.subItem {
  font-size: 0.8em;
  margin-top: 10px;
}
.itemContent ul,
li {
  display: flex;
  flex-wrap: wrap;
}
.itemContent ul li {
  padding: 0 10px;
  border-radius: 10px;
  margin-right: 10px;
  margin-top: 10px;
  height: 28px;
  line-height: 28px;
}
.itemLi {
  border: 1px solid #b3b3b3;
}
.selectActive {
  border: 1px solid #1697db;
  color: #1697db;
}
</style>