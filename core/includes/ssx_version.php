<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 */
 
  defined("SSX") or die;

 
  /**
   * Release note
   * @version 2.0.0
   * Sistema de conexão com banco de dados alterados para funcionar usando PDO
   * Classe SsxModels reconstruida para funcionar junto a PDO
   * Sistema de coleta de $_GET,$_POST,$_REQUEST,$_COOKIE e afins alterados
   * Sistema de SsxEditConstruct reconstruido para funcionar com jquery e com mais parametros
   * Sistema de proteção contra CSRF atualizado e melhorado
   * Sistema de ACL atualizado
   * Sistema de regras de acesso acrescentado
   * Sistema de plugins atualizados
   * Sistema de cadastro de usuário e senha de usuário separados para suportar diversos tipos de login
   * Acrescentado posibilitade de trocar o usuário de grupo
   * Suporte a no-render e ajax atualizados
   * Sistema de log de acesso acrescentados (coleta de ip,userAgent,sessionId)
   * Suporte a leitura de acl por ajax acrescentado.
   *  
   */
  
  
  /**
   * Release note
   * @version 1.9.1
   * Removido totalmente o uso da global Ssx
   * Adaptação de layout usando Boostrap
   * Acrescentado proteção de segurança contra ataques CSRF
   * Sistema de Feed/Rss reconstruido
   */
  
  /**
   * Release note
   * @version 1.8.0
   * 
   * Ssx adaptado para dar suporte a nova versão do php. Funções descontinuadas foram substituídas.
   * Alteração na classe de tratamento de imagem
   * Acrescentado SsxMenu para manipulação de menus
   * Melhoria nas chamadas usando Ssx.ajax
   * Acrescentado possibilidade de prefixo de tabelas
   * Acrescentado SsxActivity para determar execução em determinados pontos específicos 
   * Acrescentado possibilidade de configuração de projeto dentro do Admin
   * Acrescentado Sistema de upload de imagem por ajax
   * Sistema de Feed/Rss descontinuado (ainda é possível usa-las, mas não haverá suporte)
   * SsxPlugins melhorado possibilitando acrescimo e manutenção pelo admin
   * Suporte a base de dados Mysql com Mysqli
   * Suporte a base de dados Postgres
   * Suporte a base de dados Sqlite
   * SsxModels aprimorada e suporte a queries com JOIN e outros comandos acrescentado
   * Plugins padrões criados
   * Acrescentado módulo de páginas no admin e ck editor adicionado
   * Sistema de paginas fixas implementado.
   * Criado classe SsxEditConstruct que possibilita criar forms na área administrativa com mais facilitade.
   */
  
  /**
   * Release note
   * @version 1.3.3
   * 
   * Alterado o sistema de comunicação Ajax para suporte a orientação a objeto
   * Criado classe base para Ajax (SsxAjaxElement)
   * 
   */
  
  /**
   * Release note
   * @version 1.3.2
   * 
   * Acrescentado classe Javascript de funcoes comuns (SsxJs)
   * Acrescentado controle de usuários e autenticação padrão e modulo default de login no Admin
   * Acrescentado Sistema de Call Ajax (SsxAjax inplementada)
   * Acrescentado classe de Email Padrão (SsxMail)
   * SsxResources descontinuado. Substituido por SsxPlugins
   * Acrescentado Sistema de Output de Feed/Rss (SsxFeed)
   * Sistema de Output de Webservice aprimorado
   * Modificado a Classe SsxModels para melhor adequação de utilização
   * Criado plugin default de criação de menus no Admin
   * Refinado detecção de erros do Ssx para evitar crashes
   * Ssx melhorado para trabalhar melhor com classe de Api do Facebook
   * 
   */
  
  /**
   * Release note
   * @version 1.1.5
   * 
   * Acrescentado a SsxSession
   * Acrescentado o controle do título do projeto
   * Acrescentado a área administrativa
   * Modulos basicos removidos da area de projetos e posicionado dentro do admin
   */
  
  /**
   * Release note
   * @version 1.1.2
   * 
   * Acrescentado a SsxUtils
   * Acrescentado interface para SsxModels
   * Sistema dinamido de query para SsxModels Acrescentado
   * SsxModels aprimorada
   * Sistema de Acl aprimorado
   */
  
  /**
   * Release note
   *  @version 1.1
   * 
   * Mudado o nome de pasta para classe de classes para control
   * Colocado projeto na raiz, como irmão da pasta core, sendo pego apartir do LOCALPATH
   * Criado o tema default para todos os projetos e admin
   * 
   * */
  
  
  /**
   * Release note
   * @version 1.0
   * 
   * Ssx iniciado
   * Classe Smarty implementada
   * Banco de dados Mysql
   * Sistema de modulos e ações de modulos
   * Configuração apartir de config_set
   * Suporte a diversos temas dentro do projeto
   * Sistema de login de usuários
   * Sistema de Acl para permissionamento
   * Modulos padrões para projetos (users, group, acl, auth)
   * Sistema de link amigável para acesso aos módulos
   * SsxModels criada para facilitar manipulação de dados por parte do banco de dados
   * 
   */ 
  
  