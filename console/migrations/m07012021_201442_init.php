<?php

use yii\db\Migration;

class m07012021_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

// academicdegree
        $this->createTable('{{%academicdegree}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'status' => $this->tinyint(3)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'created_by' => $this->integer(11)->null(),
            'pos' => $this->integer(9)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// article
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'subtitle' => $this->string(300)->null(),
            'annot_text' => $this->text()->null(),
            'detail_text' => $this->text()->null(),
            'bg_img' => $this->string(255)->null(),
            'annonce_img' => $this->string(255)->null(),
            'detail_img' => $this->string(255)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->notNull(),
            'data_show' => $this->date()->null(),
            'isinindex' => $this->boolean()->notNull()->defaultValue(1),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
            'views' => $this->integer(11)->notNull()->defaultValue(0),
            'rate' => $this->float()->notNull(),
            'comments_count' => $this->integer(11)->notNull()->defaultValue(0),
            'meta_title' => $this->string(255)->null(),
            'meta_keywords' => $this->string(255)->null(),
            'meta_description' => $this->string(255)->null(),
            'slug' => $this->string(150)->notNull()->unique(),
            'pos' => $this->integer(11)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// article_article_category
        $this->createTable('{{%article_article_category}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// article_author
        $this->createTable('{{%article_author}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(11)->notNull(),
            'author_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// article_category
        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'annot_text' => $this->text()->null(),
            'detail_text' => $this->text()->null(),
            'annonce_img' => $this->string(255)->null(),
            'detail_img' => $this->integer(255)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
            'isinindex' => $this->tinyint(4)->notNull()->defaultValue(1),
            'isinlist' => $this->tinyint(4)->notNull()->defaultValue(1)->comment('отображать в списке разделов статей'),
            'slug' => $this->string(150)->notNull()->unique(),
            'meta_title' => $this->string(255)->null(),
            'meta_keywords' => $this->string(255)->null(),
            'meta_description' => $this->string(255)->null(),
            'pos' => $this->integer(11)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// auth_assignment
        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(11)->null(),
            'PRIMARY KEY (item_name, user_id)',
        ], $this->tableOptions);

// auth_item
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger(6)->notNull(),
            'description' => $this->text()->null(),
            'rule_name' => $this->string(64)->null(),
            'data' => $this->binary()->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

// auth_item_child
        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
        ], $this->tableOptions);

// auth_rule
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary()->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

// author
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(100)->notNull(),
            'lastname' => $this->string(100)->null(),
            'middlename' => $this->string(100)->notNull(),
            'avatar' => $this->string(150)->notNull(),
            'country_id' => $this->integer(11)->null(),
            'region_id' => $this->integer(11)->null(),
            'city_id' => $this->integer(11)->null(),
            'work_place' => $this->string(255)->null(),
            'position' => $this->string(500)->null(),
            'education_id' => $this->integer(11)->null(),
            'academicdegree_id' => $this->integer(11)->null(),
            'phone' => $this->string(20)->null(),
            'email' => $this->string(100)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'slug' => $this->string(250)->notNull(),
            'meta_title' => $this->string(250)->null(),
            'meta_keywords' => $this->string(250)->null(),
            'meta_description' => $this->string(250)->null(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
        ], $this->tableOptions);

// author_specialty
        $this->createTable('{{%author_specialty}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(11)->notNull(),
            'specialty_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// bonus
        $this->createTable('{{%bonus}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'bonus_value' => $this->smallInteger(6)->notNull(),
            'field_name' => $this->string(30)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
        ], $this->tableOptions);

// comment
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull(),
            'user_id' => $this->integer(11)->null(),
            'city_id' => $this->integer(11)->null(),
            'country_id' => $this->integer(11)->null(),
            'position' => $this->text()->notNull(),
            'comment_text' => $this->text()->notNull(),
            'parent_id' => $this->integer(11)->notNull(),
            'comment_type' => $this->tinyint(4)->notNull()->comment('1-статья, 2-вебинар'),
            'status' => $this->tinyint(4)->notNull()->comment('1-ожидает_проверки,2-активен,3-заблокирован_админом,4-снят_с_публикации_автором'),
        ], $this->tableOptions);

// config
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'config_type' => "ENUM ('int', 'text', 'varchar', 'html') NOT NULL DEFAULT 'int'",
            'config_value' => $this->text()->null(),
        ], $this->tableOptions);

// education
        $this->createTable('{{%education}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'status' => $this->tinyint(3)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'created_by' => $this->integer(11)->null(),
            'pos' => $this->integer(9)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// event
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull()->comment('Название'),
            'access' => $this->tinyint(4)->notNull()->comment('Уровень доступа'),
            'password' => $this->string(30)->notNull()->defaultValue('')->comment('пароль для входа на мероприятие'),
            'rule' => $this->tinyint(4)->null()->comment('[Обязательно для серии] правило генерации дат повторения событий в серийном мероприятии'),
            'description' => $this->text()->notNull()->comment('описание мероприятия. Текстовое поле. Отсуствует разметка или верстка'),
            'additionalFields' => $this->integer(11)->null()->comment('регистрационное поле. Передается в виде массива полей.   - label — название поля;   -  type — тип поля. Может быть:          - text — текстовое поле;         - radio — поле с заданными значениями; - values — массив вариантов ответа; - placeholder — значение по умолчанию'),
            'isEventRegAllowed' => $this->boolean()->notNull()->defaultValue(0)->comment('[Обязательно для серии] правило регистрации на серию. Значения:- true — регистрация осуществляется на всю серию (Event) мероприятий; - false — регистрироваться нужно на каждое отдельное мероприятие'),
            'startsAt' => $this->integer(11)->null(),
            'endsAt' => $this->integer(11)->null(),
            'image' => $this->integer(11)->null()->comment('ID картинки, которая будет фоном вебинара'),
            'imagefile' => $this->string(150)->null(),
            'type' => "ENUM ('webinar', 'meeting', '', '') NOT NULL DEFAULT 'webinar'",
            'lang' => "ENUM ('RU', 'EN', '', '') NOT NULL",
            'urlAlias' => $this->string(250)->null()->comment('замена названия вебинара в ссылке. Заменяет eventID в ссылке на вебинар; '),
            'lectorIds' => $this->json()->notNull()->comment(' ведущий на лендинге. Добавляет иконку с фото и данными ведущего. Передается как массив userID сотрудников организации'),
            'tags' => $this->json()->null(),
            'duration' => $this->string(100)->null()->comment('длительность мероприятия. Меняет значение \"Продолжительность\" на лендинге, но не определяет фактическое время завершения. Значение данного поля должно подпадать под регулярное выражение'),
            'ownerId' => $this->integer(11)->null()->comment('владелец мероприятия. UserID сотрудника организации.  По умолчанию: создатель организации'),
            'defaultRemindersEnabled' => $this->boolean()->notNull()->defaultValue(1)->comment('стандартные напоминания. Включает/отключает набор стандартных напоминаний. Значения: - true - включить напоминания за 1 ч и за 15 минут; - false - выключить напоминания за 1 ч и за 15 минут;'),
            'eventId' => $this->integer(11)->null()->comment('идентификатор шаблона'),
            'link' => $this->string(300)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);

// event_speaker
        $this->createTable('{{%event_speaker}}', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(11)->notNull(),
            'speaker_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// faq
        $this->createTable('{{%faq}}', [
            'id' => $this->primaryKey(),
            'question' => $this->string(350)->notNull(),
            'answer' => $this->text()->notNull(),
            'category_id' => $this->integer(11)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'pos' => $this->integer(11)->notNull()->defaultValue(10),
            'slug' => $this->string(250)->notNull()->unique(),
        ], $this->tableOptions);

// faq_category
        $this->createTable('{{%faq_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(350)->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'pos' => $this->integer(11)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// menu
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'lft' => $this->integer(11)->notNull(),
            'rgt' => $this->integer(11)->notNull(),
            'depth' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'url' => $this->string(250)->notNull(),
            'params' => $this->string(500)->null(),
            'menuplace' => $this->string(30)->notNull()->defaultValue('top'),
            'published' => $this->boolean()->notNull(),
        ], $this->tableOptions);

// nozology
        $this->createTable('{{%nozology}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'status' => $this->tinyint(3)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'created_by' => $this->integer(11)->null(),
            'pos' => $this->integer(9)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// page
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(300)->notNull(),
            'full_text' => $this->text()->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'slug' => $this->string(75)->notNull()->unique(),
            'meta_title' => $this->string(200)->null(),
            'meta_keywords' => $this->string(250)->null(),
            'meta_description' => $this->string(250)->null(),
            'published' => $this->tinyint(4)->null(),
            'lang' => $this->string(5)->notNull()->defaultValue('ru'),
            'category_id' => $this->integer(11)->null(),
            'templateid' => $this->tinyint(4)->notNull()->defaultValue(1),
            'pos' => $this->integer(11)->notNull()->defaultValue(1),
            'headbg' => $this->string(75)->null(),
        ], $this->tableOptions);

// pagecategory
        $this->createTable('{{%pagecategory}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(300)->notNull(),
            'description' => $this->text()->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'status' => $this->tinyint(4)->notNull(),
            'slug' => $this->string(75)->notNull()->unique(),
            'meta_title' => $this->string(200)->null(),
            'meta_keywords' => $this->string(250)->null(),
            'meta_description' => $this->string(250)->null(),
        ], $this->tableOptions);

// position
        $this->createTable('{{%position}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'status' => $this->tinyint(3)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'created_by' => $this->integer(11)->null(),
            'pos' => $this->integer(9)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// profile
        $this->createTable('{{%profile}}', [
            'user_id' => $this->integer(11)->notNull(),
            'firstname' => $this->string(100)->null(),
            'lastname' => $this->string(100)->notNull(),
            'middlename' => $this->string(100)->null(),
            'avatar' => $this->string(100)->null(),
            'birthday' => $this->date()->null(),
            'country_id' => $this->integer(11)->null(),
            'region_id' => $this->integer(11)->null(),
            'city_id' => $this->integer(11)->null(),
            'work_place' => $this->text()->null(),
            'position_id' => $this->integer(11)->null()->comment('должность'),
            'education_id' => $this->integer(11)->null()->comment('образование'),
            'academicdegree_id' => $this->integer(11)->null()->comment('ученая степень'),
            'phone' => $this->string(20)->null(),
            'email' => $this->string(255)->null(),
            'watsapp' => $this->string(20)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'last_login_at' => $this->integer(11)->null(),
            'last_login_ip' => $this->integer(11)->null(),
            'bonus' => $this->integer(9)->notNull()->defaultValue(0),
            'slug' => $this->string(250)->null(),
            'meta_title' => $this->string(250)->null(),
            'meta_keywords' => $this->string(250)->null(),
            'meta_description' => $this->string(250)->null(),
            'invitation_code' => $this->string(12)->null()->comment('код_приглашения'),
            'my_invitation_code' => $this->string(12)->null()->comment('мой_код_приглашения'),
            'PRIMARY KEY (user_id)',
        ], $this->tableOptions);

// profile_specialty
        $this->createTable('{{%profile_specialty}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'specialty_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// region
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(75)->notNull(),
            'country_id' => $this->integer(11)->null(),
            'region_id' => $this->integer(11)->null(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'region_type' => $this->tinyint(4)->null()->comment('1-страна,2-область/штат,3-город,4-пгт,5-пос,6-с,8-станица,9-д'),
            'parent_id' => $this->integer(11)->null(),
            'children' => $this->boolean()->notNull()->defaultValue(0),
            'pos' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// social_account
        $this->createTable('{{%social_account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->null(),
            'provider' => $this->string(255)->notNull()->unique(),
            'client_id' => $this->string(255)->notNull(),
            'data' => $this->text()->null(),
            'code' => $this->string(32)->null()->unique(),
            'created_at' => $this->integer(11)->null(),
            'email' => $this->string(255)->null(),
            'username' => $this->string(255)->null(),
        ], $this->tableOptions);

// speaker
        $this->createTable('{{%speaker}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(100)->notNull(),
            'lastname' => $this->string(100)->null(),
            'middlename' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'avatar' => $this->string(150)->notNull(),
            'country_id' => $this->integer(11)->null(),
            'region_id' => $this->integer(11)->null(),
            'city_id' => $this->integer(11)->null(),
            'work_place' => $this->string(255)->null(),
            'position' => $this->string(500)->null(),
            'education_id' => $this->integer(11)->null(),
            'academicdegree_id' => $this->integer(11)->null(),
            'phone' => $this->string(20)->null(),
            'email' => $this->string(100)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'slug' => $this->string(250)->notNull(),
            'meta_title' => $this->string(250)->null(),
            'meta_keywords' => $this->string(250)->null(),
            'meta_description' => $this->string(250)->null(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
            'inindex' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);

// speaker_specialty
        $this->createTable('{{%speaker_specialty}}', [
            'id' => $this->primaryKey(),
            'speaker_id' => $this->integer(11)->notNull(),
            'specialty_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// specialty
        $this->createTable('{{%specialty}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'status' => $this->tinyint(3)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'created_by' => $this->integer(11)->null(),
            'pos' => $this->integer(9)->notNull()->defaultValue(10),
        ], $this->tableOptions);

// subscribe_user
        $this->createTable('{{%subscribe_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'subscribe_type_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// subscribing_type
        $this->createTable('{{%subscribing_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'iconStyle' => $this->string(255)->null(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'pos' => $this->integer(9)->notNull()->defaultValue(10),
            'sendpulse' => $this->string(15)->null(),
        ], $this->tableOptions);

// token
        $this->createTable('{{%token}}', [
            'user_id' => $this->integer(11)->notNull(),
            'code' => $this->string(32)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'type' => $this->smallInteger(6)->notNull(),
            'PRIMARY KEY (user_id, code, type)',
        ], $this->tableOptions);

// user
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->null()->unique(),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(5),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'verification_token' => $this->string(255)->null(),
        ], $this->tableOptions);

// user_bonus
        $this->createTable('{{%user_bonus}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'bonus_id' => $this->integer(11)->notNull(),
            'bonus_value' => $this->smallInteger(6)->notNull(),
            'bonus_details' => $this->text()->notNull(),
        ], $this->tableOptions);

// webinar
        $this->createTable('{{%webinar}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(15)->notNull(),
            'access' => $this->tinyint(4)->notNull(),
            'lang' => $this->string(5)->null(),
            'startsAt' => $this->integer(11)->null(),
            'utcStartsAt' => $this->integer(11)->null(),
            'createUserId' => $this->integer(11)->null(),
            'timezoneId' => $this->integer(11)->null(),
            'endsAt' => $this->integer(11)->null(),
            'organizationId' => $this->integer(11)->null(),
            'type' => "ENUM ('webinar', 'meeting', '', '') NOT NULL DEFAULT 'webinar'",
            'description' => $this->text()->null(),
            'image' => $this->integer(11)->null()->comment('фон вебинара. ID файла в файловой системе, который будет использован в качестве фона.'),
            'bgimage' => $this->string(150)->null()->comment('фон вебинара'),
            'eventsessionId' => $this->integer(11)->null()->comment('идентификатор вебинара. Используется для регистрации на вебинары, работы с записью'),
            'urlAlias' => $this->string(250)->null(),
            'duration' => $this->smallInteger(6)->null(),
            'eventId' => $this->integer(11)->notNull()->comment('id шаблона на webinar.ru'),
            'eventIdnkomed' => $this->integer(11)->notNull()->comment('id шаблона = FK event'),
            'cssclass' => $this->string(50)->null(),
            'slug' => $this->string(250)->notNull()->unique(),
        ], $this->tableOptions);

// webinar_category
        $this->createTable('{{%webinar_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'bg_img' => $this->string(150)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(1),
            'slug' => $this->string(255)->notNull()->unique(),
            'cssclass' => $this->string(30)->null(),
        ], $this->tableOptions);

// webinar_category_event
        $this->createTable('{{%webinar_category_event}}', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// webinar_category_webinar
        $this->createTable('{{%webinar_category_webinar}}', [
            'id' => $this->primaryKey(),
            'webinar_id' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// webinar_order
        $this->createTable('{{%webinar_order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'webinar_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// webinar_speaker
        $this->createTable('{{%webinar_speaker}}', [
            'id' => $this->primaryKey(),
            'webinar_id' => $this->integer(11)->notNull(),
            'speaker_id' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

// fk: article
        $this->addForeignKey('fk_article_created_by', '{{%article}}', 'created_by', '{{%user}}', 'id');

// fk: article_article_category
        $this->addForeignKey('fk_article_article_category_article_id', '{{%article_article_category}}', 'article_id', '{{%article}}', 'id');
        $this->addForeignKey('fk_article_article_category_category_id', '{{%article_article_category}}', 'category_id', '{{%article_category}}', 'id');

// fk: article_author
        $this->addForeignKey('fk_article_author_article_id', '{{%article_author}}', 'article_id', '{{%article}}', 'id');
        $this->addForeignKey('fk_article_author_author_id', '{{%article_author}}', 'author_id', '{{%author}}', 'id');

// fk: article_category
        $this->addForeignKey('fk_article_category_created_by', '{{%article_category}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_article_category_updated_by', '{{%article_category}}', 'updated_by', '{{%user}}', 'id');

// fk: auth_assignment
        $this->addForeignKey('fk_auth_assignment_item_name', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name');

// fk: auth_item
        $this->addForeignKey('fk_auth_item_rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name');

// fk: auth_item_child
        $this->addForeignKey('fk_auth_item_child_parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name');
        $this->addForeignKey('fk_auth_item_child_child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name');

// fk: author
        $this->addForeignKey('fk_author_education_id', '{{%author}}', 'education_id', '{{%education}}', 'id');
        $this->addForeignKey('fk_author_academicdegree_id', '{{%author}}', 'academicdegree_id', '{{%academicdegree}}', 'id');

// fk: author_specialty
        $this->addForeignKey('fk_author_specialty_author_id', '{{%author_specialty}}', 'author_id', '{{%author}}', 'id');
        $this->addForeignKey('fk_author_specialty_specialty_id', '{{%author_specialty}}', 'specialty_id', '{{%specialty}}', 'id');

// fk: education
        $this->addForeignKey('fk_education_created_by', '{{%education}}', 'created_by', '{{%user}}', 'id');

// fk: event_speaker
        $this->addForeignKey('fk_event_speaker_event_id', '{{%event_speaker}}', 'event_id', '{{%event}}', 'id');
        $this->addForeignKey('fk_event_speaker_speaker_id', '{{%event_speaker}}', 'speaker_id', '{{%speaker}}', 'id');

// fk: faq
        $this->addForeignKey('fk_faq_category_id', '{{%faq}}', 'category_id', '{{%faq_category}}', 'id');

// fk: nozology
        $this->addForeignKey('fk_nozology_created_by', '{{%nozology}}', 'created_by', '{{%user}}', 'id');

// fk: page
        $this->addForeignKey('fk_page_category_id', '{{%page}}', 'category_id', '{{%pagecategory}}', 'id');

// fk: profile
        $this->addForeignKey('fk_profile_country_id', '{{%profile}}', 'country_id', '{{%region}}', 'id');
        $this->addForeignKey('fk_profile_city_id', '{{%profile}}', 'city_id', '{{%region}}', 'id');
        $this->addForeignKey('fk_profile_education_id', '{{%profile}}', 'education_id', '{{%education}}', 'id');
        $this->addForeignKey('fk_profile_academicdegree_id', '{{%profile}}', 'academicdegree_id', '{{%academicdegree}}', 'id');
        $this->addForeignKey('fk_profile_user_id', '{{%profile}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_profile_position_id', '{{%profile}}', 'position_id', '{{%position}}', 'id');

// fk: profile_specialty
        $this->addForeignKey('fk_profile_specialty_specialty_id', '{{%profile_specialty}}', 'specialty_id', '{{%specialty}}', 'id');
        $this->addForeignKey('fk_profile_specialty_user_id', '{{%profile_specialty}}', 'user_id', '{{%user}}', 'id');

// fk: social_account
        $this->addForeignKey('fk_social_account_user_id', '{{%social_account}}', 'user_id', '{{%__user}}', 'id');

// fk: speaker_specialty
        $this->addForeignKey('fk_speaker_specialty_speaker_id', '{{%speaker_specialty}}', 'speaker_id', '{{%speaker}}', 'id');
        $this->addForeignKey('fk_speaker_specialty_specialty_id', '{{%speaker_specialty}}', 'specialty_id', '{{%specialty}}', 'id');

// fk: subscribe_user
        $this->addForeignKey('fk_subscribe_user_subscribe_type_id', '{{%subscribe_user}}', 'subscribe_type_id', '{{%subscribing_type}}', 'id');
        $this->addForeignKey('fk_subscribe_user_user_id', '{{%subscribe_user}}', 'user_id', '{{%user}}', 'id');

// fk: token
        $this->addForeignKey('fk_token_user_id', '{{%token}}', 'user_id', '{{%__user}}', 'id');

// fk: user_bonus
        $this->addForeignKey('fk_user_bonus_bonus_id', '{{%user_bonus}}', 'bonus_id', '{{%bonus}}', 'id');
        $this->addForeignKey('fk_user_bonus_user_id', '{{%user_bonus}}', 'user_id', '{{%user}}', 'id');

// fk: webinar_category_event
        $this->addForeignKey('fk_webinar_category_event_category_id', '{{%webinar_category_event}}', 'category_id', '{{%webinar_category}}', 'id');
        $this->addForeignKey('fk_webinar_category_event_event_id', '{{%webinar_category_event}}', 'event_id', '{{%event}}', 'id');

// fk: webinar_category_webinar
        $this->addForeignKey('fk_webinar_category_webinar_category_id', '{{%webinar_category_webinar}}', 'category_id', '{{%webinar_category}}', 'id');
        $this->addForeignKey('fk_webinar_category_webinar_webinar_id', '{{%webinar_category_webinar}}', 'webinar_id', '{{%webinar}}', 'id');

// fk: webinar_order
        $this->addForeignKey('fk_webinar_order_user_id', '{{%webinar_order}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_webinar_order_webinar_id', '{{%webinar_order}}', 'webinar_id', '{{%webinar}}', 'id');

// fk: webinar_speaker
        $this->addForeignKey('fk_webinar_speaker_speaker_id', '{{%webinar_speaker}}', 'speaker_id', '{{%speaker}}', 'id');
        $this->addForeignKey('fk_webinar_speaker_webinar_id', '{{%webinar_speaker}}', 'webinar_id', '{{%webinar}}', 'id');



    }

    public function down()
    {

    }
}
