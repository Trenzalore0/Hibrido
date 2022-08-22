<h1 align="center">Módulo MetaTag</h1>

### :rotating_light: **Desafio**

O cliente tem uma configuração multi-site com algumas páginas CMS que são compartilhadas entre diferentes sites, 
o problema que eles estão tendo é que isso está causando problemas de conteúdo duplicado e afetando seus rankings de SEO, 
para resolver isso, precisamos criar um novo módulo que fará o seguinte:

 - Adicione um bloco ao head
 - O bloco deve ser capaz de identificar o ID da página CMS e verificar se a página é usada em múltiplas store-views
 - Nesse caso, deve adicionar uma Meta Tag hreflang ao head para cada store-view que a página esteja ativa
 - As Meta Tag’s devem exibir o idioma da loja (exemplo: en-gb, en-us, pt-br, etc...)

A estrutura da Meta Tag é a seguinte:

```php
  <link rel="alternate" hreflang="<?= $storeLanguage ?>" href="<?= $baseUrl . $cmsPageUrl ?>">
```

##
### :construction: **Durante o desenvolvimento**

Com base no desafio pensei `como poderia resolver de uma forma simples?`, sabendo que a tag deveria ser adicionada no head da página,
uma forma de adicionar blocks com php no head é usando um name no referenceBlock especifico no layout e como não é uma rota especifica pode ser
qualquer uma então usei o `default.xml` que adiciona o block em todas as rotas possíveis.

No Default.xml:
```xml
        <referenceBlock name="head.additional">

            <block 
                class="Hibrido\MetaTag\Block\Tag" 
                name="Hibrido_MetaTag_Tag" 
                template="Hibrido_MetaTag::metaTag.phtml"
            />

        </referenceBlock>
```

Agora com o meu `view/frontend/layout/default.xml` criado fica mais óbvio o que eu preciso para concluir o desafio, um template em `.phtml`
e um Block para poder associá-lo ao meu template assim fazendo uma ponte do back para o front.

No Block eu pensei em ultilizar as classes:
 - `Magento\Cms\Model\Page`: para pegar o id da pániga atual.
 - `Magento\Framework\Locale\Resolver`: para pegar o locale de uma loja com base no seu id e colocar no atributo hreflang.
 - `Magento\Cms\Model\ResourceModel\Page`: esse foi muito opcional, mas optei por colocar no construtor do meu block só por "beleza de código",
 no fim seria uma instancia dessa classe que seria usada do mesmo jeito, e é usado para ver quantas lojas usam a cmsPage atual com base em seu id.
 - `Magento\Store\Model\StoreManagerInterface`: esse é usado para pegar todos os ids das lojas no magento, E por quê?
 

Quando Olhamos para a tabela na qual o magento guarda as informações de cmsPage a `cms_page_store`, 
eu fiz um simples teste alterei o page in websites do **about-us** de allStoresViews e selecionei duas stores views,
as outras mantive o mesmo valor, quando olho para a tabela no banco de dados fica claro montar a lógica de verificação.

```text
MariaDB [magento]> select * from cms_page_store;
+---------+----------+
| page_id | store_id |
+---------+----------+
|       1 |        0 |
|       2 |        0 |
|       3 |        0 |
|       4 |        0 |
|       5 |        1 |
|       5 |        2 |
|       6 |        0 |
+---------+----------+
7 rows in set (0.000 sec)
```

Quando o store_id é 0 a cmsPage está aplicada para todas as stores views, mas quando não o magento coloca qual store view está usando a cmsPage.

Agora quando fizer uma requisição para a base de dados do magento passando o page_id da página atual e o valor retornado for 0 
sei que todas a stores views usam essa página então retorno todas as stores ids, os métodos criados no block com excecão dos métodos 
`getCmsPageUrl` e `getStoresArray`, pegam o id da store e com isso retornam algum valor.

 - `getStoresArray`: Pega os ids das stores que usam a cmsPage atual e verifica se é usado em outras stores views também.
