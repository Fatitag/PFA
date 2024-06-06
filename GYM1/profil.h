#ifndef PROFIL_H
#define PROFIL_H
#include <QtSql>
#include <QSqlQuery>
#include <QDialog>

namespace Ui {
class Profil;
}

class Profil : public QDialog
{
    Q_OBJECT

public:
    explicit Profil(QString,QWidget *parent = nullptr);
    ~Profil();

private slots:


private:
    Ui::Profil *ui;
    QSqlDatabase db;
    QString id_adhe;
};

#endif // PROFIL_H
