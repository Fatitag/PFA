#ifndef COURS_H
#define COURS_H
#include <QSqlDatabase>
#include <QSqlQuery>
#include <QDialog>

namespace Ui {
class Cours;
}

class Cours : public QDialog
{
    Q_OBJECT

public:
    explicit Cours(QWidget *parent = nullptr);
    ~Cours();

private slots:


private:
    Ui::Cours *ui;
    QSqlDatabase db ;
};

#endif // COURS_H
