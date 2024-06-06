#include "mainwindow.h"
#include "ui_mainwindow.h"
#include"seance.h"
#include"cours.h"
MainWindow::MainWindow(QString id,QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    id_adhe=id;

}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::on_pushButton_clicked()
{
    Profil* p=new Profil(id_adhe);
    p->setModal(true);//afficher le profil
    p->exec();
}


void MainWindow::on_pushButton_3_clicked()
{
    Cours* c=new Cours();
    c->setModal(true);
    c->exec();
}


void MainWindow::on_pushButton_2_clicked()
{
    Seance* s=new Seance();
    s->setModal(true);
    s->exec();
}

