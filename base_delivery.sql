-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: opmy0018.servidorwebfacil.com:3306
-- Generation Time: 14-Set-2020 às 18:54
-- Versão do servidor: 5.6.23-log
-- versão do PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rochac2lee_demo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(255) NOT NULL,
  `idUsuario` int(255) NOT NULL,
  `nota` int(255) NOT NULL,
  `comentario` longtext NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE `caixa` (
  `id` int(255) NOT NULL,
  `dataHoraAbertura` varchar(255) NOT NULL,
  `dataHoraFechamento` varchar(255) NOT NULL,
  `saldo_anterior` varchar(255) NOT NULL,
  `saldo_dia` varchar(255) NOT NULL,
  `saldo_atual` varchar(255) NOT NULL,
  `lucro` text NOT NULL,
  `prejuizo` varchar(255) NOT NULL,
  `observacao` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`id`, `dataHoraAbertura`, `dataHoraFechamento`, `saldo_anterior`, `saldo_dia`, `saldo_atual`, `lucro`, `prejuizo`, `observacao`, `status`, `data_hora_cadastro`) VALUES
(1, '2020-09-14 18:53', '2020-09-14 18:54', '0,00', '0,00', '0,00', '0,00', '', '', '0', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `status`) VALUES
(999, 'Taxa de Entrega', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_contas_pag`
--

CREATE TABLE `categoria_contas_pag` (
  `id` int(255) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoria_contas_pag`
--

INSERT INTO `categoria_contas_pag` (`id`, `nome`) VALUES
(1, '13&ordm; Sal&aacute;rio'),
(2, '&Aacute;gua e esgoto'),
(3, 'Aluguel'),
(4, 'Aquisi&ccedil;&atilde;o de equipamentos'),
(5, 'Assessorias e associaa&ccedil;&otilde;es'),
(6, 'Assist&ecirc;ncia m&eacute;dica'),
(7, 'Assist&ecirc;ncia odontol&oacute;gica'),
(8, 'Cart&oacute;rio'),
(9, 'Combust&iacute;vel'),
(10, 'Comiss&atilde;o vendedores'),
(11, 'Contabilidade'),
(12, 'Empr&eacute;stimos'),
(13, 'Energia el&eacute;trica'),
(14, 'Entregador'),
(15, 'Escrit&oacute;rio'),
(16, 'G&aacute;s de Cozinha'),
(17, 'Horas Extras'),
(18, 'Internet'),
(19, 'Investimentos'),
(20, 'Juros'),
(21, 'Limpeza'),
(22, 'Manuten&ccedil;&atilde;o de equipamentos'),
(23, 'Publicidade'),
(24, 'Reposi&ccedil;&atilde;o de Estoque'),
(25, 'Rescis&otilde;es trabalhistas'),
(26, 'Taxas banc&aacute;rias'),
(27, 'Telefone celular'),
(28, 'Telefone fixo'),
(29, 'Viagens'),
(30, 'Translado'),
(31, 'Treinamentos'),
(32, 'Vale alimenta&ccedil;&atilde;o'),
(33, 'Vale transporte'),
(34, 'Pr&oacute;-labore'),
(35, 'Transporte'),
(36, 'Alimenta&ccedil;&atilde;o'),
(37, 'Lucro'),
(38, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_contas_rec`
--

CREATE TABLE `categoria_contas_rec` (
  `id` int(255) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoria_contas_rec`
--

INSERT INTO `categoria_contas_rec` (`id`, `nome`) VALUES
(1, 'Vendas'),
(2, 'Rendimentos'),
(3, 'Boleto'),
(4, 'Cart&atilde;o'),
(5, 'Cobran&ccedil;a'),
(6, 'Comiss&atilde;o'),
(7, 'Dep&oacute;sito'),
(8, 'Empr&eacute;stimo'),
(9, 'Servi&ccedil;os'),
(10, 'Transfer&ecirc;ncia'),
(11, 'Investimento');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configs`
--

CREATE TABLE `configs` (
  `id_config` int(255) NOT NULL,
  `status` int(1) NOT NULL,
  `titulo_site` varchar(255) NOT NULL,
  `SEO_meta_titulo` varchar(255) NOT NULL,
  `SEO_meta_descricao` varchar(255) NOT NULL,
  `SEO_meta_keywords` varchar(255) NOT NULL,
  `SEO_meta_autor` varchar(255) NOT NULL,
  `conteudo_pagina` longtext NOT NULL,
  `conteudo_rodape` varchar(255) NOT NULL,
  `endereco_site` varchar(255) NOT NULL,
  `analytics_codigo` longtext NOT NULL,
  `logo_sistema` varchar(255) NOT NULL,
  `logo_login` varchar(255) NOT NULL,
  `corPrincipal` varchar(255) NOT NULL,
  `corSecundaria` varchar(255) NOT NULL,
  `corSidebarMenu` varchar(255) NOT NULL,
  `corSidebarSubMenu` varchar(255) NOT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `idTipoNegocio` int(255) NOT NULL,
  `cnpj` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `endereco_completo` longtext NOT NULL,
  `descricao_sistema` longtext NOT NULL,
  `versao_sistema` varchar(255) NOT NULL,
  `data_criacao` varchar(255) NOT NULL,
  `data_atualizacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `configs`
--

INSERT INTO `configs` (`id_config`, `status`, `titulo_site`, `SEO_meta_titulo`, `SEO_meta_descricao`, `SEO_meta_keywords`, `SEO_meta_autor`, `conteudo_pagina`, `conteudo_rodape`, `endereco_site`, `analytics_codigo`, `logo_sistema`, `logo_login`, `corPrincipal`, `corSecundaria`, `corSidebarMenu`, `corSidebarSubMenu`, `nome_empresa`, `idTipoNegocio`, `cnpj`, `telefone`, `linkedin`, `endereco_completo`, `descricao_sistema`, `versao_sistema`, `data_criacao`, `data_atualizacao`) VALUES
(1, 0, 'Sistema Delivery', 'Gerenciador do Sistema', 'Sistema de GestÃ£o Delivery', 'sistemaDelivery, Encode, Lemarde Petisco, Create Design', 'Encode', '', '', '', '', 'Encode.png', '', '#262d33', '#2e343a', '#414d58', 'rgba(65, 77, 88, 0.4)', '', 0, '', '', '', '', '', '1', '2020-05-12T00:00', '2020-09-08T18:17'),
(2, 1, '', '', '', '', '', '', '', 'encode.dev.br', '', 'logotipo-de-entrega-para-a-empresa_23-2147876885.jpg', '', '#262d33', '#2e343a', '#414d58', 'rgba(65, 77, 88, 0.4)', 'Empresa Demo', 0, '01.234.567/0001-89', '', '', '', '', '', '', ''),
(3, 1, '', '', '', '', '', '', '', 'encode.dev.br', '', 'Encode.png', '', '#262d33', '#2e343a', '#414d58', 'rgba(65, 77, 88, 0.4)', 'Empresa Demo', 0, '01.234.567/0001-89', '', '', '', '', '', '', ''),
(4, 1, '', '', '', '', '', '', '', 'encode.dev.br', '', 'Encode (1).png', '', '#262d33', '#2e343a', '#414d58', 'rgba(65, 77, 88, 0.4)', 'Empresa Demo', 0, '01.234.567/0001-89', '', '', '', '', '', '', ''),
(5, 1, 'Sistema Delivery', 'Gerenciador do Sistema', 'Sistema de GestÃ£o Delivery', 'sistemaDelivery, Encode, Lemarde Petisco, Create Design', 'Encode', '', '', 'encode.dev.br', '', 'Encode (1).png', '', '#262d33', '#2e343a', '#414d58', 'rgba(65, 77, 88, 0.4)', 'Empresa Demo', 0, '01.234.567/0001-89', '', '', '', '', '1', '2020-05-12T10:00', '2020-09-11T18:45'),
(6, 1, 'Sistema Delivery', 'Gerenciador do Sistema', 'Sistema de GestÃ£o Delivery', 'sistemaDelivery, Encode, Lemarde Petisco, Create Design', 'Encode', '', '', 'encode.dev.br', '', 'Encode (1).png', '', '#262d33', 'rgb(225, 195, 195)', '#414d58', 'rgba(65, 77, 88, 0.4)', 'Empresa Demo', 0, '01.234.567/0001-89', '', '', '', '', '1', '2020-05-12T10:00', '2020-09-11T18:45'),
(7, 1, 'Sistema Delivery', 'Gerenciador do Sistema', 'Sistema de GestÃ£o Delivery', 'sistemaDelivery, Encode, Lemarde Petisco, Create Design', 'Encode', '', '', 'encode.dev.br', '', 'Encode (1).png', '', '#262d33', 'rgb(223, 223, 223)', '#414d58', 'rgba(65, 77, 88, 0.4)', 'Empresa Demo', 0, '01.234.567/0001-89', '', '', '', '', '1', '2020-05-12T10:00', '2020-09-11T18:45');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_pag`
--

CREATE TABLE `contas_pag` (
  `id` int(255) NOT NULL,
  `tipo` int(1) NOT NULL,
  `categoria` int(255) NOT NULL,
  `dataVenc` varchar(255) NOT NULL,
  `dataRef` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `idUsuario` int(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `nDoc` varchar(255) NOT NULL,
  `codTipoDoc` varchar(255) NOT NULL,
  `observacoes` longtext NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL,
  `baixa` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_rec`
--

CREATE TABLE `contas_rec` (
  `id` int(255) NOT NULL,
  `tipo` int(1) NOT NULL,
  `categoria` int(255) NOT NULL,
  `dataVenc` varchar(255) NOT NULL,
  `dataRef` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `idUsuario` int(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `nDoc` varchar(255) NOT NULL,
  `codTipoDoc` varchar(255) NOT NULL,
  `observacoes` longtext NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL,
  `baixa` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_san`
--

CREATE TABLE `contas_san` (
  `id` int(255) NOT NULL,
  `tipo` int(1) NOT NULL,
  `categoria` int(255) NOT NULL,
  `dataVenc` varchar(255) NOT NULL,
  `dataRef` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `idUsuario` int(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `nDoc` varchar(255) NOT NULL,
  `codTipoDoc` varchar(255) NOT NULL,
  `observacoes` longtext NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL,
  `baixa` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco_cliente`
--

CREATE TABLE `endereco_cliente` (
  `id` int(255) NOT NULL,
  `idCliente` int(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` int(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `idCaixa` int(255) NOT NULL,
  `idCliente` int(255) NOT NULL,
  `idMotoboy` int(255) NOT NULL,
  `idEndereco` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `celular` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `avaliacao` int(1) NOT NULL,
  `formaPagamento` int(1) NOT NULL,
  `valorTotal` varchar(255) NOT NULL,
  `valorCobrado` varchar(255) NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL,
  `data_hora_atualizacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_itens`
--

CREATE TABLE `pedido_itens` (
  `id` int(255) NOT NULL,
  `idPedido` int(255) NOT NULL,
  `idProduto` int(255) NOT NULL,
  `quantidade` int(255) NOT NULL,
  `observacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `preco` varchar(255) NOT NULL,
  `precoPromo` varchar(255) NOT NULL,
  `lucro` varchar(255) NOT NULL,
  `descricao` longtext NOT NULL,
  `categoria` int(2) NOT NULL,
  `status` int(1) NOT NULL,
  `visivel` int(1) NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

CREATE TABLE `registros` (
  `id` int(255) NOT NULL,
  `evento` longtext NOT NULL,
  `data_hora_evento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `taxas_entrega`
--

CREATE TABLE `taxas_entrega` (
  `id` int(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `categoria` int(255) NOT NULL,
  `bairros` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `idEmpresa` int(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nascimento` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `celular` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` int(1) NOT NULL,
  `motoboy` int(1) NOT NULL,
  `taxaMotoboy` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `favorito` int(1) NOT NULL,
  `avaliacao` int(1) NOT NULL,
  `redefineSenha` int(1) NOT NULL,
  `data_hora_cadastro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `idEmpresa`, `nome`, `nascimento`, `avatar`, `celular`, `senha`, `tipo`, `motoboy`, `taxaMotoboy`, `status`, `favorito`, `avaliacao`, `redefineSenha`, `data_hora_cadastro`) VALUES
(1, 2, 'Administrador', '', 'admin.png', '(00) 00000-0001', '', 0, 0, '', 1, 0, 0, 0, '11/09/2020 18:16:09'),
(2, 2, 'Cliente Modelo', '', 'admin.png', '', '', 1, 0, '', 0, 0, 0, 0, '2020-09-11 18:56:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categoria_contas_pag`
--
ALTER TABLE `categoria_contas_pag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categoria_contas_rec`
--
ALTER TABLE `categoria_contas_rec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `contas_pag`
--
ALTER TABLE `contas_pag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contas_rec`
--
ALTER TABLE `contas_rec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contas_san`
--
ALTER TABLE `contas_san`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `endereco_cliente`
--
ALTER TABLE `endereco_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxas_entrega`
--
ALTER TABLE `taxas_entrega`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `categoria_contas_pag`
--
ALTER TABLE `categoria_contas_pag`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `categoria_contas_rec`
--
ALTER TABLE `categoria_contas_rec`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id_config` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contas_pag`
--
ALTER TABLE `contas_pag`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contas_rec`
--
ALTER TABLE `contas_rec`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contas_san`
--
ALTER TABLE `contas_san`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `endereco_cliente`
--
ALTER TABLE `endereco_cliente`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedido_itens`
--
ALTER TABLE `pedido_itens`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxas_entrega`
--
ALTER TABLE `taxas_entrega`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
