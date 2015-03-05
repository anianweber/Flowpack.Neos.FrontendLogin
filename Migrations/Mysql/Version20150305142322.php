<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Add "user" entity
 */
class Version20150305142322 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE wwwision_neos_frontendlogin_domain_model_user (persistence_object_identifier VARCHAR(40) NOT NULL, givenname VARCHAR(255) NOT NULL, familyname VARCHAR(255) NOT NULL, emailaddress VARCHAR(255) DEFAULT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE wwwision_neos_frontendlogin_domain_model_user_accounts_join (frontendlogin_user VARCHAR(40) NOT NULL, flow_security_account VARCHAR(40) NOT NULL, INDEX IDX_BA5C45334FD868C2 (frontendlogin_user), UNIQUE INDEX UNIQ_BA5C453358842EFC (flow_security_account), PRIMARY KEY(frontendlogin_user, flow_security_account)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("ALTER TABLE wwwision_neos_frontendlogin_domain_model_user_accounts_join ADD CONSTRAINT FK_BA5C45334FD868C2 FOREIGN KEY (frontendlogin_user) REFERENCES wwwision_neos_frontendlogin_domain_model_user (persistence_object_identifier)");
		$this->addSql("ALTER TABLE wwwision_neos_frontendlogin_domain_model_user_accounts_join ADD CONSTRAINT FK_BA5C453358842EFC FOREIGN KEY (flow_security_account) REFERENCES typo3_flow_security_account (persistence_object_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE wwwision_neos_frontendlogin_domain_model_user_accounts_join DROP FOREIGN KEY FK_BA5C45334FD868C2");
		$this->addSql("DROP TABLE wwwision_neos_frontendlogin_domain_model_user");
		$this->addSql("DROP TABLE wwwision_neos_frontendlogin_domain_model_user_accounts_join");
	}
}