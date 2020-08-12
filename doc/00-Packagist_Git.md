# About Git & packagist

- **Git使用过程**
```bash
1. mkdir app && cd app
2. composer init
3. vi composer.json
4. 创建远程git库yourname/yourpro
5. git remote add origin https://code.aliyun.com/yfdrc/tools.git //设置公钥略过
6. git add .&& git commit -am "init" && git pull orgin master && git push orgin master
7. 创建tag composer包版本来自于git分支和tag
   其中：分支代表dev版本，tag代表stable版本。
8. git tag 1.0.0 && git push origin --tags
9. 登录https://packagist.org/ 点击由上角的submit提交git仓库的地址
10. 添加 GitHub Service Hook domain 指向packagist的地址
```

- **新建tag并更新远程**

```bash
git tag 1.0.0 && git push origin --tags
```

- **删除tag并更新远程**
```bash
git tag -d 1.0.0 && git push origin :refs/tags/1.0.0
```