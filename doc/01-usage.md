# 使用 Drc/xxx

- 安装
- Form & Control
- DB

## 安装

```bash
composer require Drc/tools
```

## Form & Control

用于自动生成 Form & Control，具体使用方法：
```bash
use Drc\AutoMaker\MakeForm;
use Drc\AutoMaker\MakeControl;

MakeForm::create();
MakeControl::create(MakeControl::getPz());
```


## DB

用于Mysql数据的导入和导出，具体用法：
```bash
php artisan drc:dbinit
            drc:dbinmigration
            drc:dbinseed
            drc:dboutseed
            drc:dboutmigration
            drc:dboutall
            drc:dboutexcel
```
