USE [master]
GO
/****** Object:  Database [EenmaalAndermaal]    Script Date: 21-4-2021 12:38:20 ******/
CREATE DATABASE [EenmaalAndermaal]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'EenmaalAndermaal', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\EenmaalAndermaal.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'EenmaalAndermaal_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\EenmaalAndermaal_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [EenmaalAndermaal] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [EenmaalAndermaal].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [EenmaalAndermaal] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET ARITHABORT OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET AUTO_CLOSE ON 
GO
ALTER DATABASE [EenmaalAndermaal] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [EenmaalAndermaal] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [EenmaalAndermaal] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET  ENABLE_BROKER 
GO
ALTER DATABASE [EenmaalAndermaal] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [EenmaalAndermaal] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [EenmaalAndermaal] SET  MULTI_USER 
GO
ALTER DATABASE [EenmaalAndermaal] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [EenmaalAndermaal] SET DB_CHAINING OFF 
GO
ALTER DATABASE [EenmaalAndermaal] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [EenmaalAndermaal] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [EenmaalAndermaal] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [EenmaalAndermaal] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
ALTER DATABASE [EenmaalAndermaal] SET QUERY_STORE = OFF
GO
USE [EenmaalAndermaal]
GO
/****** Object:  Table [dbo].[Bestand]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Bestand](
	[Filenaam] [char](13) NOT NULL,
	[Voorwerp] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Filenaam] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Bod]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Bod](
	[Bodbedrag] [decimal](19, 4) NOT NULL,
	[BodDag] [date] NOT NULL,
	[Gebruiker] [char](10) NOT NULL,
	[BodTijdstip] [time](7) NOT NULL,
	[Voorwerp] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Voorwerp] ASC,
	[Bodbedrag] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Feedback]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Feedback](
	[Commentaar] [char](12) NOT NULL,
	[Dag] [date] NOT NULL,
	[Feedbacksoort] [char](8) NOT NULL,
	[SoortGebruiker] [char](8) NOT NULL,
	[Tijdstip] [time](7) NOT NULL,
	[Voorwerp] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Voorwerp] ASC,
	[SoortGebruiker] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Gebruiker]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Gebruiker](
	[Gebruikersnaam] [char](10) NOT NULL,
	[Voornaam] [char](15) NOT NULL,
	[Achternaam] [char](15) NOT NULL,
	[Adresregel_1] [char](50) NULL,
	[Adresregel_2] [char](50) NULL,
	[Postcode] [char](7) NOT NULL,
	[Plaatsnaam] [char](20) NOT NULL,
	[Landnaam] [char](9) NOT NULL,
	[GeboorteDag] [date] NOT NULL,
	[Mailbox] [char](25) NOT NULL,
	[Wachtwoord] [char](25) NOT NULL,
	[Vraag] [int] NOT NULL,
	[Antwoordtekst] [char](15) NOT NULL,
	[Verkoper] [bit] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Gebruikersnaam] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Gebruikerstelefoon]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Gebruikerstelefoon](
	[Volgnr] [int] NOT NULL,
	[Gebruiker] [char](10) NOT NULL,
	[Telefoon] [char](11) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Volgnr] ASC,
	[Gebruiker] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Rubriek]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Rubriek](
	[Rubrieknummer] [int] NOT NULL,
	[Rubrieknaam] [char](24) NOT NULL,
	[Rubriek] [int] NOT NULL,
	[Volgnr] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Rubrieknummer] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Verkoper]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Verkoper](
	[Gebruiker] [char](10) NOT NULL,
	[Bank] [char](8) NULL,
	[Bankrekening] [int] NULL,
	[ControleOptie] [char](10) NOT NULL,
	[Creditcard] [char](19) NULL,
PRIMARY KEY CLUSTERED 
(
	[Gebruiker] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Voorwerp]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Voorwerp](
	[Voorwerpnummer] [int] IDENTITY(1,1) NOT NULL,
	[Titel] [char](18) NOT NULL,
	[Beschrijving] [char](30) NOT NULL,
	[Startprijs] [decimal](19, 4) NOT NULL,
	[Betalingswijze] [char](9) NOT NULL,
	[Betalingsinstructie] [char](23) NULL,
	[Plaatsnaam] [char](12) NOT NULL,
	[Land] [char](9) NOT NULL,
	[Looptijd] [tinyint] NOT NULL,
	[LooptijdbeginDag] [date] NOT NULL,
	[LooptijdbeginTijdstip] [time](7) NOT NULL,
	[Verzendkosten] [decimal](19, 4) NOT NULL,
	[Verzendinstructies] [char](27) NULL,
	[Verkoper] [char](10) NOT NULL,
	[Koper] [char](10) NULL,
	[LooptijdeindeDag] [date] NOT NULL,
	[LooptijdEindeTijdstip] [time](7) NOT NULL,
	[VeilingGesloten] [bit] NOT NULL,
	[Verkoopprijs] [decimal](19, 4) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Voorwerpnummer] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[VoorwerpInRubriek]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[VoorwerpInRubriek](
	[Voorwerp] [int] NOT NULL,
	[RubriekOpLaagstNiveau] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Voorwerp] ASC,
	[RubriekOpLaagstNiveau] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Vraag]    Script Date: 21-4-2021 12:38:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Vraag](
	[Vraagnummer] [int] NOT NULL,
	[TekstVraag] [char](30) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Vraagnummer] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Voorwerp] ADD  DEFAULT ((7)) FOR [Looptijd]
GO
ALTER TABLE [dbo].[Bestand]  WITH CHECK ADD FOREIGN KEY([Voorwerp])
REFERENCES [dbo].[Voorwerp] ([Voorwerpnummer])
GO
ALTER TABLE [dbo].[Bod]  WITH CHECK ADD FOREIGN KEY([Gebruiker])
REFERENCES [dbo].[Gebruiker] ([Gebruikersnaam])
GO
ALTER TABLE [dbo].[Bod]  WITH CHECK ADD FOREIGN KEY([Voorwerp])
REFERENCES [dbo].[Voorwerp] ([Voorwerpnummer])
GO
ALTER TABLE [dbo].[Feedback]  WITH CHECK ADD FOREIGN KEY([Voorwerp])
REFERENCES [dbo].[Voorwerp] ([Voorwerpnummer])
GO
ALTER TABLE [dbo].[Gebruiker]  WITH CHECK ADD FOREIGN KEY([Vraag])
REFERENCES [dbo].[Vraag] ([Vraagnummer])
GO
ALTER TABLE [dbo].[Gebruikerstelefoon]  WITH CHECK ADD FOREIGN KEY([Gebruiker])
REFERENCES [dbo].[Gebruiker] ([Gebruikersnaam])
GO
ALTER TABLE [dbo].[Rubriek]  WITH CHECK ADD FOREIGN KEY([Rubriek])
REFERENCES [dbo].[Rubriek] ([Rubrieknummer])
GO
ALTER TABLE [dbo].[Verkoper]  WITH CHECK ADD FOREIGN KEY([Gebruiker])
REFERENCES [dbo].[Gebruiker] ([Gebruikersnaam])
GO
ALTER TABLE [dbo].[Voorwerp]  WITH CHECK ADD FOREIGN KEY([Koper])
REFERENCES [dbo].[Gebruiker] ([Gebruikersnaam])
GO
ALTER TABLE [dbo].[Voorwerp]  WITH CHECK ADD FOREIGN KEY([Verkoper])
REFERENCES [dbo].[Verkoper] ([Gebruiker])
GO
ALTER TABLE [dbo].[VoorwerpInRubriek]  WITH CHECK ADD FOREIGN KEY([RubriekOpLaagstNiveau])
REFERENCES [dbo].[Rubriek] ([Rubrieknummer])
GO
ALTER TABLE [dbo].[VoorwerpInRubriek]  WITH CHECK ADD FOREIGN KEY([RubriekOpLaagstNiveau])
REFERENCES [dbo].[Rubriek] ([Rubrieknummer])
GO
ALTER TABLE [dbo].[VoorwerpInRubriek]  WITH CHECK ADD FOREIGN KEY([RubriekOpLaagstNiveau])
REFERENCES [dbo].[Rubriek] ([Rubrieknummer])
GO
ALTER TABLE [dbo].[VoorwerpInRubriek]  WITH CHECK ADD FOREIGN KEY([RubriekOpLaagstNiveau])
REFERENCES [dbo].[Rubriek] ([Rubrieknummer])
GO
ALTER TABLE [dbo].[VoorwerpInRubriek]  WITH CHECK ADD FOREIGN KEY([Voorwerp])
REFERENCES [dbo].[Voorwerp] ([Voorwerpnummer])
GO
ALTER TABLE [dbo].[Bod]  WITH CHECK ADD CHECK  (([Bodbedrag]>=(0)))
GO
ALTER TABLE [dbo].[Feedback]  WITH CHECK ADD  CONSTRAINT [chk_Feedbacksoortnaam] CHECK  (([Feedbacksoort]='Positief' OR [Feedbacksoort]='Neutraal' OR [Feedbacksoort]='Negatief'))
GO
ALTER TABLE [dbo].[Feedback] CHECK CONSTRAINT [chk_Feedbacksoortnaam]
GO
ALTER TABLE [dbo].[Feedback]  WITH CHECK ADD  CONSTRAINT [chk_Soortgebruiker] CHECK  (([SoortGebruiker]='Verkoper' OR [SoortGebruiker]='Koper'))
GO
ALTER TABLE [dbo].[Feedback] CHECK CONSTRAINT [chk_Soortgebruiker]
GO
ALTER TABLE [dbo].[Verkoper]  WITH CHECK ADD  CONSTRAINT [chk_ControleOptie] CHECK  (([ControleOptie]='Post' OR [ControleOptie]='Creditcard'))
GO
ALTER TABLE [dbo].[Verkoper] CHECK CONSTRAINT [chk_ControleOptie]
GO
ALTER TABLE [dbo].[Voorwerp]  WITH CHECK ADD CHECK  (([Startprijs]>=(0)))
GO
ALTER TABLE [dbo].[Voorwerp]  WITH CHECK ADD CHECK  (([Verkoopprijs]>=(0)))
GO
ALTER TABLE [dbo].[Voorwerp]  WITH CHECK ADD CHECK  (([Verzendkosten]>=(0)))
GO
USE [master]
GO
ALTER DATABASE [EenmaalAndermaal] SET  READ_WRITE 
GO
