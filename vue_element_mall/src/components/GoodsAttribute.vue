<template>
  <div>
    <div class="popupSub">已选规格：{{ selectStr }}</div>
    <div class="subItem" v-for="(item,index) in specList" :key="index">
      <div class="itemTitle">{{ item.title }}</div>
      <div class="itemContent">
        <ul>
          <li
              class="itemLi"
              v-for="(its,ins) in item.list"
              :key="its.content + ins"
              @click="changeSpec(item.id,its,its.able)"
              :class="chooseClass(item,its)"
          >
            {{ its.content }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
// import {specList, skuList} from '@/data'

export default {
  name: "GoodsAttribute",
  props: ["gid", "g_info"],
  data() {
    return {
      specList: [],
      skuList: [],
      selectSpec: {},
      selectStr: '无',
      resSpecList: {},
    }
  },
  created() {
    console.log("gid", this.gid)
    this.$api.goods.getSpecKvInfoByGoodsId(this.gid)
        .then(res => {
          this.skuList = res.data.message.skuList;
          this.resSpecList = res.data.message.specList;

          // 处理数据
          // 初始化选择数据的对象
          this.resSpecList.forEach(item => {
            // this.$set(this.selectSpec, item.title, {});
            this.$set(this.selectSpec, item.id, {});
          })
          // 将规格数据处理成我们视图所需要的数据类型
          this.specList = this.resSpecList.map(item => {
            return {
              id: item.id,
              title: item.title,
              list: item.list.map(its => {
                return {
                  id: its.id,
                  content: its.content,
                  // 判断是否可以选择
                  able: this.isAble(item.id, its)  // 注释的调试看逻辑代码 false
                }
              })
            }
          })
          // console.log(JSON.stringify(this.selectSpec))
          // 注释的调试看逻辑代码
          // this.selectSpec = {
          //   '颜色':'',
          //   '套餐':'套餐一',
          //   '内存':'64G'
          // }
          // this.isAble('颜色', '红色')
        })
        .catch(err => {
          console.log(err)
        })


  },
  methods: {
    // 判断规格是否可以被选择  核心函数 key当前的规格的id   value规格值
    isAble(key, value) {
      // 深拷贝 避免被影响
      var copySelectSpec = JSON.parse(JSON.stringify(this.selectSpec));
      // 用对象的好处就在这了 直接赋值当前验证项
      copySelectSpec[key] = value;
      // 用数组的 some 方法 效率高 符合条件直接退出循环
      let flag = this.skuList.some(item => {
        // 条件判断 核心逻辑判断
        // console.log(item)
        var i = 0;
        // 这个for in 循环的逻辑就对底子不深的人来说就看不懂了 原理就是循环已经选中的 和 正在当前对比的数据 和 所有的sku对比 只有当前验证的所有项满足sku中的规格或者其他规格为空时 即满足条件 稍微有点复杂 把注释的调试代码打开就调试下就可以看懂了
        for (let k in copySelectSpec) {
          //  console.log(copySelectSpec[k])  // 注释的调试看逻辑代码
          if (Object.keys(copySelectSpec[k]).length > 0
              // && JSON.stringify(item.specs).includes(JSON.stringify(copySelectSpec[k])) !== -1) {
              && this.findItem(item.specs, "id", copySelectSpec[k].id)) {
            i++
          } else if (Object.keys(copySelectSpec[k]).length === 0) {
            i++;
          }
        }
        // 符合下面条件就退出了 不符合会一直循环知道循环结束没有符合的条件就 return false 了
        // console.log(i) // 注释的调试看逻辑代码
        return i === this.resSpecList.length
      })
      return flag
    },
    // 点击事件
    changeSpec(key, value, able) {
      // console.log("test", value, able)
      if (!able) return


      if (Object.keys(this.selectSpec[key]).length > 0
          && this.selectSpec[key].id === value.id) {
        this.selectSpec[key] = {}
      } else {
        const tmp = {};
        tmp.content = value.content
        tmp.id = value.id
        this.selectSpec[key] = tmp;
      }
      // forEach循环改变原数组
      this.specList.forEach(item => {
        item.list.forEach(its => {
          its.able = this.isAble(item.id, its);
        });
      });
      this.selectStr = ' ';
      let count = 0;
      for (let index in this.selectSpec) {
        if (Object.keys(this.selectSpec[index]).length > 0) {
          count++;
          this.selectStr = this.selectSpec[index].content + ", " + this.selectStr
        }
        if (this.selectStr.length <= 0) {
          this.selectStr = '无'
        }
      }
      if (count === Object.keys(this.selectSpec).length) {
        this.$api.goods.getGoodsInfoBySpecKv(this.selectSpec, this.gid)
            .then(res => {
              this.g_info(res.data.message)
            })
            .catch(err => {
              console.log(err)
            })
        console.log("fini");
      }
    },
    chooseClass(item, its) {
      let classStr = '';
      if (this.selectSpec[item.id].id === its.id) {
        classStr += 'selectActive'
      } else if (!its.able) {
        classStr += 'disabled'
      }
      return classStr;
    },
    findItem(arr, key, val) {
      for (let i = 0; i < arr.length; i++) {
        if (arr[i][key] === val) {
          return true
        }
      }
      return false
    },
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

.disabled {
  cursor: not-allowed;
  background-color: #fff;
  border-color: #ebeef5;
  color: #b1b1b1;
  text-decoration: line-through;
}
</style>
