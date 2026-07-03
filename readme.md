# LaraBBS - Laravel 论坛系统

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-5.7-orange.svg" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-7.1+-blue.svg" alt="PHP Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/Vue-2.5-green.svg" alt="Vue Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

## 目录

- [项目简介](#项目简介)
- [功能特性](#功能特性)
- [技术栈](#技术栈)
- [项目结构](#项目结构)
- [核心机制详解](#核心机制详解)
- [数据库结构](#数据库结构)
- [安装部署](#安装部署)
- [API 文档](#api-文档)
- [任务调度](#任务调度)
- [测试](#测试)
- [常用命令](#常用命令)
- [安全特性](#安全特性)
- [性能优化](#性能优化)
- [生产环境部署](#生产环境部署)
- [常见问题](#常见问题)
- [贡献指南](#贡献指南)
- [许可证](#许可证)
- [致谢](#致谢)
- [架构设计说明](#架构设计说明)

## 项目简介

LaraBBS 是一个基于 Laravel 5.7 开发的现代化论坛系统，支持 Web 端和 RESTful API，具备完整的用户认证、话题管理、回复互动、通知系统等核心功能。同时集成微信小程序、微信公众号、短信服务、极光推送等多平台能力。

本项目源自 [Laravel China 社区](https://laravel-china.org/) 的《Laravel 教程 - Web 开发实战进阶》及《Laravel 教程 - API 开发实战》课程，在课程基础上进行了完整的工程化实践，涵盖前后端分离、队列任务、缓存策略、权限控制、定时调度等真实业务场景。

### 核心亮点

- **Web + API 双端支持**：Web 端使用 Blade + Bootstrap 渲染，API 端基于 Dingo/API + JWT 提供 RESTful 接口
- **多渠道认证**：支持邮箱密码、短信验证码、微信 OAuth、微信小程序四种登录方式
- **活跃用户算法**：基于话题发布与回复的加权评分算法，通过 Redis 缓存实现高性能计算
- **SEO 友好**：话题 URL 自动生成英文 Slug（百度翻译 API + 拼音降级方案）
- **实时推送**：话题被回复时通过极光推送（JPush）向作者发送通知
- **后台管理**：集成 Laravel Administrator，支持内容管理、角色权限配置、站点设置

## 功能特性

### 核心功能
- **用户系统**：注册、登录、邮箱验证、密码重置、个人资料管理
- **话题系统**：发布、编辑、删除话题，支持 Markdown 编辑器
- **分类系统**：话题按分类组织，支持分类筛选
- **回复系统**：对话题进行评论和回复
- **通知系统**：话题被回复时自动通知作者，支持数据库通知和极光推送
- **权限管理**：基于角色的访问控制（RBAC），支持 Founder、Maintainer 等角色
- **活跃用户**：加权评分算法计算活跃用户，首页侧边栏展示 Top 6
- **友情链接**：资源推荐展示，支持后台管理与缓存
- **后台管理**：基于 Laravel Administrator 的内容管理后台

### API 功能
- **RESTful API**：完整的 API 接口，支持 JWT 认证
- **第三方登录**：微信 OAuth、微信小程序登录
- **短信服务**：支持短信验证码注册/登录（云片网关）
- **图片验证码**：注册前获取图片验证码防止滥用
- **图片上传**：头像、话题图片上传，支持尺寸裁剪
- **频率限制**：API 接口访问频率控制（访问接口 60 次/分钟，登录接口 10 次/分钟）
- **通知管理**：通知列表、未读统计、批量标记已读
- **权限查询**：获取当前用户角色与权限列表

### 管理功能
- **后台管理**：基于 Laravel Administrator 的内容管理（用户、话题、分类、回复、友情链接）
- **站点设置**：站点名称、联系人邮箱、SEO 信息配置
- **队列任务**：异步处理通知推送、Slug 翻译等任务
- **Horizon 监控**：队列任务实时监控面板
- **开发辅助**：SudoSu 模块（开发环境快速切换用户身份）

## 技术栈

### 后端
| 技术/组件 | 版本 | 说明 |
|-----------|------|------|
| Laravel Framework | 5.7.* | PHP Web 框架 |
| PHP | ^7.1.3 | PHP 版本要求 |
| Dingo/API | ^2.0.0-alpha2 | API 开发工具包 |
| JWT Auth | 1.0.0-rc.3 | API 身份认证 |
| Redis (Predis) | ~1.1 | 缓存、队列存储、活跃时间记录 |
| Laravel Horizon | ~1.3 | 队列监控面板 |
| Spatie Permission | ~2.29 | 角色权限管理（RBAC） |
| Intervention Image | ^2.4 | 图片处理（裁剪、压缩） |
| GuzzleHTTP | ~6.3 | HTTP 客户端（百度翻译 API 调用） |
| Easy SMS | ^1.1 | 短信服务（云片网关） |
| Laravel WeChat | ~4.0 | 微信 SDK（公众号、小程序） |
| JPush | ^3.6 | 极光推送（回复通知推送） |
| HTML Purifier | ~2.0 | XSS 过滤（用户输入清洗） |
| Overtrue Pinyin | ~3.0 | 拼音转换（Slug 降级方案） |
| SocialiteProviders Weixin | ^4.0 | 微信 OAuth 登录 |
| Laravel Administrator | ~1.1 | 后台管理系统 |
| Doctrine DBAL | ^2.9 | 数据库抽象层 |
| Gregwar Captcha | ^1.1 | 图片验证码生成 |
| SudoSu | ~1.1 | 开发环境用户切换工具 |

### 前端
| 技术/组件 | 版本 | 说明 |
|-----------|------|------|
| Vue.js | ^2.5.17 | 前端框架 |
| Bootstrap | ^4.0.0 | UI 框架 |
| jQuery | ^3.5 | DOM 操作 |
| Axios | ^0.18 | HTTP 请求 |
| Laravel Mix | ^4.0.7 | 前端构建工具（Webpack 封装） |
| Sass | ^1.15.2 | CSS 预处理器 |
| FontAwesome | ^5.6.3 | 图标库 |

### 开发工具
| 工具 | 说明 |
|------|------|
| Laravel Debugbar | 开发调试工具栏 |
| Laravel Query Logger | SQL 查询日志记录 |
| Laravel Dump Server | 服务端变量转储 |
| PHPUnit | ^7.0 单元测试框架 |
| Mockery | 测试模拟框架 |
| Laravel Generator | 代码生成器 |

## 项目结构

```
larabbs/
├── app/
│   ├── Console/
│   │   ├── Commands/              # 自定义 Artisan 命令
│   │   │   ├── CalculateActiveUser.php   # 计算活跃用户
│   │   │   ├── SyncUserActivedAt.php     # 同步用户活跃时间（Redis→DB）
│   │   │   └── GenerateToken.php         # 生成测试用 JWT Token
│   │   └── Kernel.php             # 任务调度注册
│   ├── Exceptions/                # 异常处理
│   ├── Handlers/                  # 业务处理器
│   │   ├── ImageUploadHandler.php # 图片上传（裁剪、格式校验、分目录存储）
│   │   └── SlugTranslateHandler.php # Slug 翻译（百度API + 拼音降级）
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/               # API 控制器（Dingo/API）
│   │   │   ├── Auth/              # 认证控制器
│   │   │   ├── TopicsController.php    # 话题 CRUD + 图片上传
│   │   │   ├── UsersController.php     # 用户资料管理
│   │   │   ├── RepliesController.php   # 回复管理
│   │   │   ├── CategoriesController.php # 分类展示
│   │   │   ├── NotificationsController.php # 通知列表
│   │   │   └── PagesController.php     # 静态页面
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php        # 用户认证
│   │   │   ├── EnsureEmailIsVerified.php # 邮箱验证检查
│   │   │   ├── RecordLastActivedTime.php # 记录用户活跃时间
│   │   │   └── ChangeLocale.php        # API 语言切换
│   │   └── Requests/             # 表单请求验证（Web + API）
│   ├── Jobs/
│   │   └── TranslateSlug.php      # 异步翻译话题 Slug（队列任务）
│   ├── Listeners/
│   │   ├── EmailVerified.php      # 邮箱验证后处理
│   │   └── PushNotification.php   # 极光推送回复通知
│   ├── Models/
│   │   ├── User.php               # 用户模型（JWT、角色、通知、活跃用户）
│   │   ├── Topic.php              # 话题模型（排序作用域、SEO链接）
│   │   ├── Reply.php              # 回复模型
│   │   ├── Category.php           # 分类模型
│   │   ├── Link.php               # 友情链接模型（缓存）
│   │   ├── Image.php              # 图片模型（多态关联）
│   │   └── Traits/
│   │       ├── ActiveUserHelper.php    # 活跃用户算法（加权评分 + 缓存）
│   │       └── LastActivedAtHelper.php # 用户活跃时间（Redis Hash 存储）
│   ├── Notifications/
│   │   └── TopicReplied.php       # 话题被回复通知（数据库频道）
│   ├── Observers/                 # 模型观察者
│   │   ├── UserObserver.php       # 用户创建初始化
│   │   ├── TopicObserver.php      # 话题保存时清洗内容、生成摘要、翻译Slug
│   │   ├── ReplyObserver.php      # 回复创建时更新计数、发送通知
│   │   └── LinkObserver.php       # 友情链接缓存清理
│   ├── Policies/                  # 授权策略
│   │   ├── TopicPolicy.php        # 话题更新/删除权限
│   │   ├── ReplyPolicy.php        # 回复删除权限
│   │   └── UserPolicy.php         # 用户资料更新权限
│   ├── Providers/                 # 服务提供者
│   │   ├── EasySmsServiceProvider.php # 短信服务注册
│   │   ├── JpushServiceProvider.php   # 极光推送注册
│   │   └── EventServiceProvider.php   # 事件监听注册
│   ├── Transformers/              # API 数据转换器（Fractal）
│   │   ├── UserTransformer.php
│   │   ├── TopicTransformer.php
│   │   ├── ReplyTransformer.php
│   │   ├── CategoryTransformer.php
│   │   ├── NotificationTransformer.php
│   │   ├── ImageTransformer.php
│   │   ├── LinksTransformer.php
│   │   ├── PermissionsTransformer.php
│   │   └── RoleTransformer.php
│   └── helpers.php                # 全局辅助函数
├── config/                        # 配置文件（33个）
│   ├── api.php                    # Dingo/API 配置（频率限制、JWT认证）
│   ├── administrator/             # 后台管理配置
│   │   ├── settings/site.php      # 站点设置
│   │   ├── users.php, topics.php, categories.php, ...
│   │   └── roles.php, permissions.php
│   ├── easysms.php                # 短信网关配置（云片）
│   ├── jpush.php                  # 极光推送配置
│   ├── wechat.php                 # 微信 SDK 配置
│   ├── horizon.php                # 队列监控配置
│   ├── purifier.php               # HTML 过滤配置
│   └── ...
├── database/
│   ├── migrations/                # 数据库迁移（24个）
│   ├── factories/                 # 模型工厂（User, Topic, Reply, Link）
│   └── seeds/                     # 数据种子
├── resources/
│   ├── views/                     # Blade 模板（26个）
│   │   ├── layouts/               # 布局模板（header, footer, app）
│   │   ├── topics/                # 话题页面（列表、详情、编辑、侧边栏）
│   │   ├── users/                 # 用户页面（资料、话题、回复）
│   │   ├── auth/                  # 认证页面（登录、注册、密码重置、邮箱验证）
│   │   ├── notifications/         # 通知页面
│   │   └── shared/                # 共享组件（错误提示、消息）
│   ├── js/                        # JavaScript 源码
│   └── sass/                      # Sass 样式
├── routes/
│   ├── web.php                    # Web 路由
│   └── api.php                    # API 路由（Dingo/API，v1）
├── public/                        # 入口文件、静态资源
├── tests/                         # 测试代码
│   ├── Feature/                   # 功能测试（TopicApiTest）
│   ├── Unit/                      # 单元测试
│   └── Traits/ActingJWTUser.php   # JWT 认证测试辅助 Trait
└── storage/                       # 存储文件
```

## 核心机制详解

### 活跃用户算法

系统通过加权评分算法计算活跃用户，在首页侧边栏展示 Top 6。

**评分规则：**

| 行为 | 权重 | 说明 |
|------|------|------|
| 发布话题 | ×4 | 7天内发布的话题数量 × 4 |
| 发布回复 | ×1 | 7天内发布的回复数量 × 1 |

**计算流程：**
1. 统计最近 7 天内发布过话题的用户，按 `话题数 × 4` 计算得分
2. 统计最近 7 天内发布过回复的用户，按 `回复数 × 1` 累加得分
3. 按总得分降序排列，截取前 6 名
4. 结果缓存至 Redis，有效期 65 分钟
5. 通过定时任务每小时重新计算一次

> 详见 `app/Models/Traits/ActiveUserHelper.php`

### Slug 翻译机制

话题保存时自动生成 SEO 友好的英文 Slug，用于构建可读性更强的 URL。

**翻译策略（降级机制）：**
1. **优先调用百度翻译 API**：将话题标题从中文翻译为英文，生成 Slug
2. **降级为拼音方案**：若百度翻译 API 未配置或请求失败，使用 Overtrue Pinyin 库将标题转换为拼音
3. **异步执行**：翻译任务通过队列异步处理（`TranslateSlug` Job），不阻塞用户请求

**配置项（`.env`）：**
```env
BAIDU_TRANSLATE_APPID=your_baidu_appid
BAIDU_TRANSLATE_KEY=your_baidu_key
```

> 详见 `app/Handlers/SlugTranslateHandler.php` 和 `app/Jobs/TranslateSlug.php`

### 用户活跃时间记录

系统通过 Redis + MySQL 双层存储记录用户最后活跃时间，兼顾性能与持久化。

**工作流程：**
1. **实时写入 Redis**：每次用户请求时，中间件 `RecordLastActivedTime` 将当前时间写入 Redis Hash（按日期分表，如 `users_last_actived_at2026-07-03`）
2. **定时同步 MySQL**：每天凌晨 00:00，定时任务 `larabbs:sync-user-actived-at` 将前一天的 Redis 数据同步到数据库，并清除 Redis 中的旧数据
3. **读取优先 Redis**：访问器 `getLastActivedAtAttribute` 优先从 Redis 读取当天数据，取不到再回退到数据库字段

> 详见 `app/Models/Traits/LastActivedAtHelper.php` 和 `app/Console/Kernel.php`

### 通知系统

话题被回复时，系统自动向话题作者发送通知，支持两种渠道：

| 渠道 | 说明 | 触发条件 |
|------|------|----------|
| 数据库通知 | 存入 `notifications` 表，Web/API 端可查看 | 话题作者 ≠ 回复者 |
| 极光推送 | 通过 JPush 向作者移动设备推送 | 本地环境不推送 + 作者已绑定 registration_id |

**通知数据结构：**
```json
{
  "reply_id": 1,
  "reply_content": "回复内容",
  "user_id": 2,
  "user_name": "回复者名称",
  "user_avatar": "头像URL",
  "topic_link": "话题链接#reply1",
  "topic_id": 1,
  "topic_title": "话题标题"
}
```

> 详见 `app/Notifications/TopicReplied.php` 和 `app/Listeners/PushNotification.php`

### 图片上传处理

`ImageUploadHandler` 统一处理所有图片上传，具备以下能力：

- **格式校验**：仅允许 png、jpg、gif、jpeg 格式
- **分目录存储**：按 `uploads/images/{类型}/{年月日}/` 组织文件，提高查找效率
- **文件命名**：`{前缀}_{时间戳}_{随机字符串}.{后缀}`，前缀通常为模型 ID
- **尺寸裁剪**：支持设定最大宽度，等比缩放（GIF 格式不裁剪以保留动画）
- **URL 拼接**：自动拼接站点完整 URL 返回

> 详见 `app/Handlers/ImageUploadHandler.php`

### XSS 防护

系统使用 HTML Purifier（`mews/purifier`）对所有用户输入的 HTML 内容进行清洗：

- 话题保存时，`TopicObserver::saving()` 调用 `clean()` 过滤 `body` 字段
- 回复创建时，`ReplyObserver::creating()` 调用 `clean()` 过滤 `content` 字段
- 过滤规则配置在 `config/purifier.php`，使用 `user_topic_body` 配置集

## 数据库结构

### 主要数据表

| 表名 | 说明 | 关联关系 |
|------|------|----------|
| `users` | 用户表 | hasMany: topics, replies; notifications |
| `topics` | 话题表 | belongsTo: user, category; hasMany: replies |
| `replies` | 回复表 | belongsTo: user, topic |
| `categories` | 分类表 | hasMany: topics |
| `notifications` | 通知表 | morphTo: notifiable (User) |
| `links` | 友情链接表 | - |
| `images` | 图片表 | morphTo: user |
| `users` (扩展字段) | - | phone, weixin_openid, weixin_unionid, registration_id, weixin_session_key, weapp_openid, last_actived_at, notification_count |
| `roles` / `permissions` | 角色权限表 | Spatie Permission (多态关联 model_has_roles, model_has_permissions) |
| `password_resets` | 密码重置令牌表 | - |
| `failed_jobs` | 失败队列任务表 | - |

### 角色与权限

系统预置以下角色（通过数据种子初始化）：

| 角色 | 说明 | 典型权限 |
|------|------|----------|
| `Founder` | 站长 | 全部权限，包括后台管理、站点设置 |
| `Maintainer` | 维护者 | 内容管理权限 |
| `User` | 普通用户 | 基本的发帖、回复权限 |

> 详见 `database/migrations/2019_01_31_104836_seed_roles_and_permissions_data.php`

## 安装部署

### 环境要求

- PHP >= 7.1.3
- MySQL >= 5.7
- Redis
- Composer
- Node.js & NPM (或 Yarn)

### 安装步骤

1. **克隆项目**
```bash
git clone https://github.com/PanNinan/larabbs.git
cd larabbs
```

2. **安装 PHP 依赖**
```bash
composer install
```

3. **安装前端依赖**
```bash
npm install
# 或使用 Yarn
yarn install
```

4. **编译前端资源**
```bash
npm run dev
# 生产环境编译
npm run prod
```

5. **配置环境变量**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

6. **编辑 `.env` 文件**，配置数据库、Redis、邮件、微信、短信、推送等参数：
```env
APP_NAME=LaraBBS
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# 数据库
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larabbs
DB_USERNAME=root
DB_PASSWORD=your_password

# Redis（缓存、队列、活跃时间记录）
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# 缓存与队列驱动（建议生产环境使用 Redis）
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

# 邮件
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

# JWT
JWT_SECRET=your_jwt_secret

# 百度翻译（Slug 生成，不配置则降级为拼音）
BAIDU_TRANSLATE_APPID=your_baidu_appid
BAIDU_TRANSLATE_KEY=your_baidu_key

# 云片短信
YUNPIAN_API_KEY=your_yunpian_api_key
REALLY_SEND=false

# 微信 OAuth 登录
WEIXIN_KEY=your_weixin_app_id
WEIXIN_SECRET=your_weixin_app_secret

# 微信小程序
WECHAT_MINI_PROGRAM_APPID=your_mini_app_id
WECHAT_MINI_PROGRAM_SECRET=your_mini_app_secret

# 极光推送
JPUSH_KEY=your_jpush_key
JPUSH_SECRET=your_jpush_secret

# Dingo/API 配置
API_STANDARDS_TREE=prs
API_VERSION=v1
API_DEBUG=false
```

7. **执行数据库迁移**
```bash
php artisan migrate
```

8. **填充初始数据**
```bash
php artisan db:seed
```

9. **创建存储目录软链接**
```bash
php artisan storage:link
```

10. **启动队列监听（可选，用于异步任务）**
```bash
php artisan horizon
```

### 开发环境

```bash
# 启动开发服务器
php artisan serve

# 监听前端资源变化
npm run watch

# 启动队列（开发环境可使用同步队列）
php artisan queue:work

# 启动 Horizon 面板（访问 /horizon）
php artisan horizon
```

## API 文档

### API 基础信息
- **Base URL**: `/api`
- **版本**: v1
- **认证方式**: JWT Token
- **响应格式**: JSON
- **频率限制**: 访问接口 60 次/分钟，登录类接口 10 次/分钟

### 响应格式

**成功响应（单个资源）：**
```json
{
  "data": {
    "id": 1,
    "title": "话题标题",
    "body": "话题内容",
    "user_id": 1,
    "category_id": 1,
    "created_at": "2026-07-03 10:00:00",
    "updated_at": "2026-07-03 10:00:00"
  }
}
```

**列表响应（分页）：**
```json
{
  "data": [...],
  "meta": {
    "pagination": {
      "total": 100,
      "count": 15,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 7,
      "links": {
        "previous": null,
        "next": "http://example.com/api/topics?page=2"
      }
    }
  }
}
```

**错误响应：**
```json
{
  "message": "错误描述",
  "errors": {},
  "code": "ERROR_CODE",
  "status_code": 400
}
```

### 主要接口

#### 公开接口（无需 Token）
| 方法 | 路径 | 说明 |
|------|------|------|
| POST | `/api/verificationCodes` | 发送短信验证码 |
| POST | `/api/captchas` | 获取图片验证码 |
| POST | `/api/users` | 用户注册 |
| POST | `/api/authorizations` | 用户登录（邮箱/手机号） |
| PUT | `/api/authorizations/current` | 刷新 Token |
| DELETE | `/api/authorizations/current` | 删除 Token（退出登录） |
| POST | `/api/socials/{type}/authorizations` | 第三方登录（微信） |
| POST | `/api/weapp/authorizations` | 微信小程序登录 |
| POST | `/api/weapp/users` | 微信小程序注册 |
| GET | `/api/categories` | 获取分类列表 |
| GET | `/api/topics` | 获取话题列表（支持排序） |
| GET | `/api/topics/{topic}` | 话题详情 |
| GET | `/api/topics/{topic}/replies` | 话题回复列表 |
| GET | `/api/users/{user}/topics` | 用户话题列表 |
| GET | `/api/users/{user}/replies` | 用户回复列表 |
| GET | `/api/links` | 友情链接列表 |
| GET | `/api/actived/users` | 活跃用户列表 |

#### 认证接口（需要 Token）
| 方法 | 路径 | 说明 |
|------|------|------|
| GET | `/api/user` | 当前用户信息 |
| PATCH | `/api/user` | 更新用户信息 |
| POST | `/api/images` | 上传图片 |
| POST | `/api/topics` | 发布话题 |
| PATCH | `/api/topics/{topic}` | 更新话题 |
| DELETE | `/api/topics/{topic}` | 删除话题 |
| POST | `/api/topics/{topic}/replies` | 发布回复 |
| DELETE | `/api/topics/{topic}/replies/{reply}` | 删除回复 |
| GET | `/api/user/notifications` | 通知列表 |
| GET | `/api/user/notifications/stats` | 通知未读统计 |
| PATCH | `/api/user/read/notifications` | 标记通知已读 |
| GET | `/api/user/permissions` | 当前用户权限列表 |
| GET | `/api/user/roles` | 当前用户角色列表 |

### 认证方式

在请求头中添加 JWT Token：
```
Authorization: Bearer {your-jwt-token}
```

API 支持通过 `Accept` 头指定版本和格式：
```
Accept: application/prs.larabbs.v1+json
```

## 任务调度

系统通过 Laravel Scheduler 注册了以下定时任务（需配置 Cron 每分钟执行 `php artisan schedule:run`）：

| 任务 | 频率 | 说明 |
|------|------|------|
| `larabbs:calculate-active-user` | 每小时 | 计算并缓存活跃用户列表 |
| `larabbs:sync-user-actived-at` | 每天 00:00 | 将 Redis 中的用户活跃时间同步到数据库 |

**Cron 配置示例：**
```bash
* * * * * cd /path-to-larabbs && php artisan schedule:run >> /dev/null 2>&1
```

## 测试

项目使用 PHPUnit 进行自动化测试，包含功能测试和单元测试。

**已有测试：**
- `TopicApiTest`：话题 API 的完整 CRUD 测试（创建、更新、查看、列表、删除）
- 使用 `ActingJWTUser` Trait 简化 JWT 认证测试
- 使用 Model Factory 生成测试数据

**运行测试：**
```bash
# 运行所有测试
phpunit

# 运行指定测试文件
phpunit tests/Feature/TopicApiTest.php

# 运行并输出详细结果
phpunit --testdox
```

**测试数据库配置：**

测试使用 `RefreshDatabase` Trait，每次测试自动迁移并回滚数据库，确保测试隔离性。

## 常用命令

```bash
# ========== 数据库 ==========
php artisan migrate              # 执行迁移
php artisan migrate:rollback     # 回滚上一次迁移
php artisan migrate:fresh --seed # 重置数据库并重新填充数据
php artisan db:seed              # 填充种子数据
php artisan db:seed --class=UsersTableSeeder  # 填充指定种子

# ========== 队列 ==========
php artisan queue:work           # 启动队列 worker
php artisan queue:retry all      # 重试所有失败任务
php artisan horizon              # 启动 Horizon（队列监控）
php artisan horizon:terminate    # 优雅停止 Horizon

# ========== 缓存 ==========
php artisan cache:clear          # 清空应用缓存
php artisan config:cache         # 缓存配置（生产环境）
php artisan route:cache          # 缓存路由（生产环境）
php artisan view:cache           # 缓存视图

# ========== 项目专用命令 ==========
php artisan larabbs:calculate-active-user    # 计算活跃用户
php artisan larabbs:sync-user-actived-at     # 同步用户活跃时间
php artisan larabbs:generate-token           # 生成测试用 JWT Token（交互式）
php artisan jwt:secret                       # 生成 JWT 密钥

# ========== 开发工具 ==========
php artisan tinker              # 交互式 REPL
npm run watch                   # 监听前端资源变化
npm run hot                     # 热模块替换开发
```

## 安全特性

- **CSRF 保护**：所有 Web 表单提交经过 CSRF 验证
- **XSS 过滤**：使用 HTML Purifier 过滤用户输入（话题内容、回复内容）
- **SQL 注入防护**：使用 Eloquent ORM 参数绑定，杜绝原始 SQL 拼接
- **接口频率限制**：API 接口访问频率控制（Dingo/API throttle 中间件）
- **JWT Token 认证**：API 使用 JWT 进行无状态身份验证
- **角色权限控制**：基于 Spatie Permission 的 RBAC，细粒度权限管理
- **邮箱验证**：注册后需验证邮箱才能发布内容
- **图片验证码**：注册前需获取图片验证码，防止接口滥用
- **密码加密**：使用 bcrypt 加密存储，修改器自动处理
- **授权策略**：话题/回复/用户操作通过 Policy 进行权限校验

## 性能优化

- **Redis 缓存**：活跃用户列表、友情链接等热点数据缓存至 Redis
- **数据库索引**：关键字段添加索引优化查询
- **队列任务**：Slug 翻译、通知推送等耗时操作异步处理
- **Horizon 监控**：实时监控队列任务执行情况与性能指标
- **图片压缩**：使用 Intervention Image 对上传图片进行等比裁剪
- **N+1 查询优化**：话题列表使用 Eager Loading（`with('user', 'category')`）
- **配置缓存**：生产环境缓存配置、路由、视图
- **Redis 活跃时间**：用户活跃时间先写 Redis，定时批量同步数据库，减少写入压力

## 生产环境部署

### 1. 服务器环境准备

```bash
# 安装 PHP 扩展
sudo apt install php7.2-fpm php7.2-mysql php7.2-redis php7.2-mbstring php7.2-xml php7.2-gd php7.2-curl

# 安装 Redis
sudo apt install redis-server

# 安装 Supervisor（进程守护）
sudo apt install supervisor
```

### 2. 项目部署

```bash
# 克隆代码
git clone https://github.com/PanNinan/larabbs.git /var/www/larabbs
cd /var/www/larabbs

# 安装依赖（不安装开发依赖）
composer install --optimize-autoloader --no-dev

# 配置环境
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 编辑 .env，设置 APP_ENV=production, APP_DEBUG=false

# 编译前端资源
npm install && npm run prod

# 数据库迁移
php artisan migrate --force

# 缓存优化
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 创建软链接
php artisan storage:link
```

### 3. Supervisor 配置（队列守护）

```ini
[program:larabbs-horizon]
process_name=%(program_name)s
command=php /var/www/larabbs/artisan horizon
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/larabbs/storage/logs/horizon.log
stopwaitsecs=3600
```

### 4. Cron 配置

```bash
* * * * * cd /var/www/larabbs && php artisan schedule:run >> /dev/null 2>&1
```

### 5. Nginx 配置示例

```nginx
server {
    listen 80;
    server_name larabbs.example.com;
    root /var/www/larabbs/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 常见问题

### Q: 话题 Slug 没有翻译成英文？
**A:** 检查 `.env` 中是否配置了 `BAIDU_TRANSLATE_APPID` 和 `BAIDU_TRANSLATE_KEY`。未配置时会自动降级为拼音方案。同时确认队列是否正常运行（`php artisan horizon` 或 `php artisan queue:work`）。

### Q: 短信验证码无法发送？
**A:** 检查 `.env` 中 `YUNPIAN_API_KEY` 是否正确配置，`REALLY_SEND` 设为 `true` 才会真正发送短信（开发环境默认为 `false`）。

### Q: 极光推送不生效？
**A:** 推送仅在非本地环境生效（`app()->environment('local')` 时跳过）。同时用户需已绑定 `registration_id`（移动端登录时传入）。

### Q: Horizon 面板无法访问？
**A:** 确认 `config/horizon.php` 中的权限配置。默认仅 `Founder` 角色可访问。生产环境需通过 Supervisor 守护 Horizon 进程。

### Q: API 返回 429 Too Many Requests？
**A:** 触发了频率限制。访问接口限制为 60 次/分钟，登录类接口限制为 10 次/分钟。可在 `config/api.php` 的 `rate_limits` 中调整。

### Q: 后台管理无法访问？
**A:** 后台管理基于 `summerblue/administrator`，访问路径默认为 `/admin`。需拥有 `Founder` 或 `Maintainer` 角色权限。配置文件位于 `config/administrator.php`。

### Q: 图片上传后无法显示？
**A:** 确认已执行 `php artisan storage:link` 创建软链接，且 `public/uploads/images/` 目录有写入权限。

## 贡献指南

欢迎提交 Issue 和 Pull Request。

1. Fork 本仓库
2. 创建你的特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交你的修改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 打开一个 Pull Request

**代码规范：**
- 遵循 PSR-2 编码规范
- 新增功能需附带测试用例
- 提交信息遵循 Conventional Commits 规范

## 许可证

本项目基于 [MIT](https://opensource.org/licenses/MIT) 许可证开源。

## 致谢

- [Laravel](https://laravel.com/) - 优秀的 PHP 框架
- [Laravel China 社区](https://laravel-china.org/) - 教程和文档支持
- [Summer](https://github.com/summerblue) - 《Laravel 教程》作者，本项目源于其教程实践
- [Dingo/API](https://github.com/dingo/api) - 强大的 RESTful API 工具包
- [Spatie](https://github.com/spatie/laravel-permission) - 权限管理方案
- [Overtrue](https://github.com/overtrue) - 微信 SDK、短信、拼音等优秀开源库

## 架构设计说明

### 路由设计

#### Web 路由 (`routes/web.php`)
- 首页路由指向话题列表
- 自定义认证路由（登录、注册、密码重置、邮箱验证）
- RESTful 资源路由：users、topics、categories、replies、notifications
- 图片上传专用路由
- 权限拒绝页面路由

#### API 路由 (`routes/api.php`)
使用 Dingo/API 包管理，版本为 v1：
- **命名空间**: `App\Http\Controllers\Api`
- **中间件**: `serializer:array`, `bindings`, `ChangeLocale`
- **频率限制**: 普通接口 60 次/分钟，登录相关 10 次/分钟
- **认证**: 通过 `api.auth` 中间件组保护需要登录的接口
- **JWT 认证**: 使用 Dingo 的 JWT Provider

### 控制器设计

#### Web 控制器
| 控制器 | 主要方法 | 功能 |
|--------|----------|------|
| `TopicsController` | index, show, create, store, edit, update, destroy, uploadImage | 话题 CRUD、图片上传 |
| `UsersController` | show, edit, update | 用户资料展示与编辑 |
| `RepliesController` | store, destroy | 回复发布与删除 |
| `CategoriesController` | show | 分类话题列表 |
| `NotificationsController` | index | 通知列表展示 |
| `PagesController` | root, permissionDenied | 首页、权限拒绝页 |

#### API 控制器
| 控制器 | 主要方法 | 功能 |
|--------|----------|------|
| `UsersController` | store, update, me, activedIndex, weappStore | 用户注册、更新、当前用户、活跃用户、小程序注册 |
| `TopicsController` | index, show, store, update, destroy, userIndex | 话题 API 操作 |
| `RepliesController` | index, store, destroy, userIndex | 回复 API 操作 |
| `AuthorizationsController` | store, update, destroy, socialStore, weappStore | JWT 认证、第三方登录、小程序登录 |
| `VerificationCodesController` | store | 短信验证码发送 |
| `CaptchasController` | store | 图片验证码生成 |
| `ImagesController` | store | 图片上传处理 |
| `NotificationsController` | index, stats, read | 通知列表、统计、标记已读 |
| `PermissionsController` | index | 当前用户权限列表 |
| `LinksController` | index | 友情链接列表 |

### 模型设计

#### 模型关系图
```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│    users    │       │   topics    │       │  categories │
├─────────────┤       ├─────────────┤       ├─────────────┤
│ id          │──┐    │ id          │   ┌───│ id          │
│ name        │  │    │ title       │   │   │ name        │
│ email       │  │    │ body        │   │   │ description │
│ phone       │  │    │ slug        │   │   └─────────────┘
│ avatar      │  │    │ excerpt     │   │
│ password    │  │    │ user_id     │───┘
│ introduction│  └───>│ category_id │───┘
│ weixin_*    │       │ reply_count │
│ registration│       │ view_count  │
│ last_actived│       │ ...         │
│ notif_count │       └─────────────┘
└─────────────┘              │
       │                     │
       │              ┌──────┘
       │              ▼
       │       ┌─────────────┐
       │       │   replies   │
       │       ├─────────────┤
       │       │ id          │
       └──────>│ user_id     │
               │ topic_id    │
               │ content     │
               └─────────────┘

┌─────────────┐  ┌──────────────┐  ┌─────────────────┐
│   links     │  │   images     │  │ notifications   │
├─────────────┤  ├──────────────┤  ├─────────────────┤
│ id          │  │ id           │  │ id              │
│ title       │  │ user_id      │  │ notifiable_type │
│ link        │  │ path         │  │ notifiable_id   │
│ ...         │  │ (多态关联)    │  │ type            │
└─────────────┘  └──────────────┘  │ data            │
                                   │ read_at         │
                                   └─────────────────┘
```

#### 模型特性

**User 模型**
- 实现 `JWTSubject` 接口（API 认证）
- 实现 `MustVerifyEmail` 接口（邮箱验证）
- 使用 `HasRoles` Trait（Spatie 权限管理）
- 使用自定义 Trait：`ActiveUserHelper`（活跃用户算法）、`LastActivedAtHelper`（活跃时间记录）
- 关联关系：`topics()`, `replies()`
- 访问器/修改器：`setPasswordAttribute`（自动加密）、`setAvatarAttribute`（URL 拼接）、`getLastActivedAtAttribute`（Redis 优先读取）
- 自定义 `notify()` 方法：跳过自我通知，自动递增未读计数

**Topic 模型**
- 作用域方法：`scopeWithOrder`（排序入口）、`scopeRecent`（按创建时间）、`scopeRecentReplied`（按更新时间）
- 关联关系：`category()`, `user()`, `replies()`
- 生成 SEO 友好的 URL：`link()` 方法

**Link 模型**
- 自定义 `$cache_key` 属性，支持缓存
- `LinkObserver` 在保存时自动清除缓存

### 请求验证

使用 Laravel 的 Form Request 进行请求验证：

| 请求类 | 用途 |
|--------|------|
| `TopicRequest` | 话题创建/编辑验证（Web） |
| `ReplyRequest` | 回复发布验证（Web） |
| `UserRequest` | 用户信息更新验证（Web） |
| `Api\UserRequest` | API 用户注册/更新验证 |
| `Api\TopicRequest` | API 话题创建/更新验证 |
| `Api\AuthorizationRequest` | API 登录验证 |
| `Api\VerificationCodeRequest` | 短信验证码请求验证 |
| `Api\CaptchaRequest` | 图片验证码请求验证 |
| `Api\SocialAuthorizationRequest` | 第三方登录验证 |
| `Api\WeappAuthorizationRequest` | 小程序登录验证 |
| `Api\ImageRequest` | 图片上传验证 |

### 数据转换器 (Transformers)

使用 Fractal 进行 API 数据转换：

| 转换器 | 包含关系 |
|--------|----------|
| `UserTransformer` | roles |
| `TopicTransformer` | user, category |
| `ReplyTransformer` | user, topic |
| `CategoryTransformer` | - |
| `NotificationTransformer` | - |
| `ImageTransformer` | - |
| `LinksTransformer` | - |
| `PermissionsTransformer` | - |
| `RoleTransformer` | - |

### 中间件

| 中间件 | 用途 |
|--------|------|
| `Authenticate` | 用户认证（Web 端跳转登录页） |
| `EnsureEmailIsVerified` | 邮箱验证检查（发布内容前） |
| `RecordLastActivedTime` | 记录用户最后活跃时间至 Redis |
| `ChangeLocale` | API 语言切换（读取 `Accept-Language` 请求头） |
| `api.throttle` | API 频率限制 |
| `api.auth` | API JWT 认证 |
| `serializer:array` | Dingo/API 序列化格式 |
| `bindings` | Dingo/API 路由模型绑定 |

### 队列任务

| 任务类 | 队列 | 用途 |
|--------|------|------|
| `TranslateSlug` | default | 异步翻译话题 Slug（百度翻译 API / 拼音降级） |

### 事件监听

| 监听器 | 触发事件 | 用途 |
|--------|----------|------|
| `SendEmailVerificationNotification` | `Registered` | 注册后发送验证邮件 |
| `EmailVerified` | `Verified` | 邮箱验证后处理 |
| `WeixinExtendSocialite` | `SocialiteWasCalled` | 注册微信 OAuth 社交登录 |
| `PushNotification` | `DatabaseNotification.created` | 回复通知极光推送 |

### 模型观察者

| 观察者 | 观察模型 | 触发时机 | 用途 |
|--------|----------|----------|------|
| `UserObserver` | User | created | 用户创建后初始化 |
| `TopicObserver` | Topic | saving | 清洗 HTML 内容、生成摘要 |
| `TopicObserver` | Topic | saved | 分发 Slug 翻译队列任务 |
| `ReplyObserver` | Reply | creating | 清洗回复 HTML 内容 |
| `ReplyObserver` | Reply | created | 更新话题回复计数、发送通知 |
| `LinkObserver` | Link | saved | 清除友情链接缓存 |

### 授权策略

| 策略 | 资源 | 权限控制 |
|------|------|----------|
| `TopicPolicy` | Topic | update（仅作者）、destroy（仅作者） |
| `ReplyPolicy` | Reply | destroy（作者或话题作者） |
| `UserPolicy` | User | update（仅本人） |

### 全局辅助函数

定义在 `app/helpers.php`，通过 Composer autoload 自动加载：

| 函数 | 用途 |
|------|------|
| `route_class()` | 获取当前路由名并替换 `.` 为 `-`（用于 CSS 高亮） |
| `category_nav_active($category_id)` | 分类导航高亮判断 |
| `make_excerpt($value, $length)` | 从 HTML 内容生成摘要 |
| `model_admin_link($title, $model)` | 生成后台管理链接 |
| `model_link($title, $model, $prefix)` | 生成模型详情链接 |
| `model_plural_name($model)` | 获取模型的复数蛇形命名 |

---

<p align="center">Made with ❤️ by <a href="https://github.com/PanNinan">PanNinan</a></p>
