
# git 的用法


### 在错误的分支进行了工作，如何实现将工作合并到正确的分支呢


有多个分支，当前工作的分支是 feature-memo，在你修改多个文件后，才发现，自己应当切换到 feature-office 分支下工作才对的。
这时候，怎么办呢？

第一步：在 feature-memo 分支中，先做 git add . 与 git commit；

第二步：git checkout 至到 feature-office 分支；



### 删除分支

删除分支：git branch -d feature-office

```
warning: deleting branch 'feature-office' that has been merged to
         'refs/remotes/origin/feature-office', but not yet merged to HEAD.
Deleted branch feature-office (was ab1a91c).
```

强制删除分支：git branch -D feature-office