<template>
  <div class="upload-container-e">
    <el-upload
      action="http://tradding.loc/api/media_objects"
      list-type="picture-card"
      :headers="headers"
      :on-preview="handlePictureCardPreview"
      :on-success="handlePictureCardSuccess"
      :on-remove="handleRemove"
      :file-list="fileList"
    >
      <i class="el-icon-plus" />
    </el-upload>
    <el-dialog :visible.sync="dialogVisible">
      <img width="100%" :src="dialogImageUrl" alt="">
    </el-dialog>
  </div>
</template>

<script>
import { getToken } from '@/utils/auth.js'
import { fetchMedia } from '@/api/media.js'

export default {
  props: {
    value: {
      type: Array,
      default: () => { return [] }
    }
  },
  data() {
    return {
      fileList: [],
      dialogImageUrl: '',
      dialogVisible: false
    }
  },
  computed: {
    headers() {
      return {
        'Authorization': `Bearer ${getToken()}`
      }
    }
  },
  created() {
    this.loadMedia()
  },
  methods: {
    emitInput(val) {
      this.$emit('input', val)
    },
    loadMedia() {
      let uri
      for (uri in this.value) {
        fetchMedia(this.value[uri]).then(response => {
          console.log(response)
          this.fileList.push({
            'url': 'http://tradding.loc/' + response.contentUrl,
            'name': response.contentUrl
          })
        }).catch(err => {
          console.log(err)
        })
      }
    },
    handlePictureCardSuccess(file, fileList) {
      // this.emitInput(file.files.file)
      this.fileList.push(fileList.response['@id'])
      console.log(this.fileList)
      this.emitInput(this.fileList)
    },
    handleRemove(file, fileList) {
      console.log('Removing file from list of files')
      console.log(file)
      console.log(fileList)
      fileList = fileList.filter(file)
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~@/styles/mixin.scss";
.upload-container {
  width: 100%;
  position: relative;
  @include clearfix;
  .image-uploader {
    width: 35%;
    float: left;
  }
  .image-preview {
    width: 200px;
    height: 200px;
    position: relative;
    border: 1px dashed #d9d9d9;
    float: left;
    margin-left: 50px;
    .image-preview-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
      img {
        width: 100%;
        height: 100%;
      }
    }
    .image-preview-action {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      cursor: default;
      text-align: center;
      color: #fff;
      opacity: 0;
      font-size: 20px;
      background-color: rgba(0, 0, 0, .5);
      transition: opacity .3s;
      cursor: pointer;
      text-align: center;
      line-height: 200px;
      .el-icon-delete {
        font-size: 36px;
      }
    }
    &:hover {
      .image-preview-action {
        opacity: 1;
      }
    }
  }
  .image-app-preview {
    width: 320px;
    height: 180px;
    position: relative;
    border: 1px dashed #d9d9d9;
    float: left;
    margin-left: 50px;
    .app-fake-conver {
      height: 44px;
      position: absolute;
      width: 100%; // background: rgba(0, 0, 0, .1);
      text-align: center;
      line-height: 64px;
      color: #fff;
    }
  }
}
</style>
