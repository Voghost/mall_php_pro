<template>
  <el-row
      :gutter="16"
      type="flex"
      justify="space-between"
  >
    <el-col :span="12">
      <el-cascader
          v-model="dis"
          :options="regionData"
          @change="handleAddressChange"
          style="width: 100%"
          filterable
      />
    </el-col>
    <el-col :span="12">
      <el-input
          v-model="address"
          placeholder="请输入地址"
          @change="handleChange"
      />
    </el-col>
  </el-row>
</template>

<script>
import { regionData, CodeToText, TextToCode } from 'element-china-area-data'
export default {
  name: 'AddressChoose',
  props: {
    value: {
      type: Object,
      default () {
        return {
          address: '',
          areaCity: '',
          areaCode: '',
          areaDistrict: '',
          areaProvince: ''
        }
      }
    }
  },
  model: {
    prop: 'value',
    event: 'change'
  },
  data () {
    return {
      dis: [],
      regionData,
      mapLabel: TextToCode,
      mapCode: CodeToText,
      ...this.value
    }
  },
  methods: {
    // eslint-disable-next-line no-unused-vars
    handleChange (e) {
      let val = {
        ...this.value,
        address: this.address
      }
      this.$emit('update:value', val)
      this.$emit('change', val)
    },
    handleAddressChange (values) {
      console.log(values)
      const b = ['areaProvince', 'areaCity', 'areaDistrict']
      if (values.length > 0) {
        let initialValue = {
          ...this.value,
          'areaProvince': '',
          'areaCity': '',
          'areaDistrict': '',
          'areaCode': values[values.length - 1]
        }
        const val = values.reduce((acc, curret, index) => {
          let value = this.mapCode[curret]

          return {
            ...acc,
            [b[index]]: value
          }
        }, initialValue)
        this.$emit('change', val)
        // sync更新
        // this.$emit('update:value', val)
      }
    },
    getCurrentRegion (val) {
      let address = val
      if (!Array.isArray(val) && typeof val === 'object') {
        let { areaProvince, areaCity = '', areaCode } = val
        address = [this.mapLabel[areaProvince], this.mapLabel[areaCity], areaCode]
        if (address.some(item => item === undefined)) address = []
      }
      return address
    },
    initDis (val) {
      this.dis = this.dis.length === 0 ? this.getCurrentRegion(val) : this.dis
    }
  },
  created () {
    if (this.regionData.length > 0 && this.value.areaCode) {
      this.initDis(this.value)
    }
  },
  watch: {
    value: {
      handler (val) {
        this.address = val.address
        if (this.regionData.length > 0) {
          this.initDis(val)
        }
        if (Object.values(val).every(item => !item)) this.dis = []
      },
      deep: true
    }
  }
}
</script>

<style scoped>

</style>